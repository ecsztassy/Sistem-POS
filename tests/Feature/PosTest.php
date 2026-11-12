<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Item;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use App\Services\CheckoutService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Tests\TestCase;

class PosTest extends TestCase
{
    use RefreshDatabase;

    private function item(array $attributes = []): Item
    {
        return Item::create($attributes + ['category_id' => Category::create(['name' => 'Minuman'])->id, 'item_code' => (string) Str::uuid(), 'name' => 'Teh', 'buy_price' => 3000, 'sell_price' => 5000, 'stock' => 10, 'unit' => 'pcs']);
    }

    private function payload(Item $item, array $attributes = []): array
    {
        return $attributes + ['checkout_token' => (string) Str::uuid(), 'pay_amount' => 15000, 'items' => [['item_id' => $item->id, 'qty' => 2]]];
    }

    public function test_sales_below_cost_record_a_negative_profit(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $item = $this->item(['buy_price' => 6000]);
        $this->post(route('pos.checkout'), $this->payload($item))->assertSessionHasNoErrors();
        $this->get(route('reports.index'))->assertOk()->assertViewHas('profit', -2000);
        $this->get(route('dashboard'))->assertOk()->assertViewHas('profit', -2000);
    }

    public function test_write_failure_rolls_back_transaction_and_details(): void
    {
        $user = User::factory()->create();
        $item = $this->item();
        $event = 'eloquent.creating: '.TransactionDetail::class;
        Event::listen($event, function () {
            throw new \RuntimeException('Simulated database write failure');
        });
        try {
            app(CheckoutService::class)->checkout($user, $this->payload($item));
            $this->fail('Expected checkout to fail.');
        } catch (\RuntimeException $exception) {
            $this->assertSame('Simulated database write failure', $exception->getMessage());
        } finally {
            Event::forget($event);
        }
        $this->assertDatabaseCount('transactions', 0);
        $this->assertDatabaseCount('transaction_details', 0);
        $this->assertEquals(10, $item->fresh()->stock);
    }

    public function test_checkout_calculates_server_prices_and_preserves_snapshots(): void
    {
        $user = User::factory()->create();
        $item = $this->item();
        $this->actingAs($user)->post(route('pos.checkout'), $this->payload($item, ['total_price' => 1]))->assertSessionHasNoErrors()->assertRedirect();
        $transaction = Transaction::firstOrFail();
        $this->assertEquals(10000, $transaction->total_price);
        $this->assertEquals(5000, $transaction->change_amount);
        $this->assertEquals(8, $item->fresh()->stock);
        $this->assertEquals(3000, $transaction->details->first()->buy_price);
        $item->update(['name' => 'Nama baru', 'buy_price' => 9000, 'sell_price' => 12000]);
        $item->delete();
        $this->get(route('pos.receipt', $transaction))->assertOk()->assertSee('Teh')->assertDontSee('Nama baru');
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->get(route('reports.index'))->assertOk()->assertViewHas('profit', 4000);
    }

    public function test_insufficient_stock_or_payment_leaves_database_unchanged(): void
    {
        $this->actingAs(User::factory()->create());
        $item = $this->item();
        $this->post(route('pos.checkout'), $this->payload($item, ['pay_amount' => 1]))->assertSessionHasErrors('pay_amount');
        $this->post(route('pos.checkout'), $this->payload($item, ['items' => [['item_id' => $item->id, 'qty' => 11]]]))->assertSessionHasErrors('items');
        $this->assertDatabaseCount('transactions', 0);
        $this->assertDatabaseCount('transaction_details', 0);
        $this->assertEquals(10, $item->fresh()->stock);
    }

    public function test_multiple_items_fail_atomically(): void
    {
        $this->actingAs(User::factory()->create());
        $a = $this->item();
        $b = $this->item(['stock' => 0]);
        $this->post(route('pos.checkout'), $this->payload($a, ['items' => [['item_id' => $a->id, 'qty' => 1], ['item_id' => $b->id, 'qty' => 1]]]))->assertSessionHasErrors('items');
        $this->assertEquals(10, $a->fresh()->stock);
        $this->assertDatabaseCount('transactions', 0);
    }

    public function test_repeated_checkout_is_idempotent(): void
    {
        $this->actingAs(User::factory()->create());
        $item = $this->item();
        $data = $this->payload($item);
        $this->post(route('pos.checkout'), $data)->assertSessionHasNoErrors();
        $this->post(route('pos.checkout'), $data)->assertSessionHasNoErrors();
        $this->assertDatabaseCount('transactions', 1);
        $this->assertEquals(8, $item->fresh()->stock);
    }

    public function test_invalid_quantities_duplicates_and_archived_items_are_rejected(): void
    {
        $this->actingAs(User::factory()->create());
        $item = $this->item();
        foreach ([0, -1, 1.5] as $qty) {
            $this->post(route('pos.checkout'), $this->payload($item, ['items' => [['item_id' => $item->id, 'qty' => $qty]]]))->assertSessionHasErrors('items.0.qty');
        }
        $this->post(route('pos.checkout'), $this->payload($item, ['items' => [['item_id' => $item->id, 'qty' => 1], ['item_id' => $item->id, 'qty' => 1]]]))->assertSessionHasErrors('items.0.item_id');
        $item->delete();
        $this->post(route('pos.checkout'), $this->payload($item))->assertSessionHasErrors('items');
        $this->assertDatabaseCount('transactions', 0);
    }

    public function test_cashiers_cannot_access_admin_pages_or_other_cashier_receipts(): void
    {
        $user = User::factory()->create();
        $item = $this->item();
        $this->actingAs($user)->post(route('pos.checkout'), $this->payload($item));
        $transaction = Transaction::firstOrFail();
        $this->actingAs(User::factory()->create());
        foreach (['dashboard', 'items', 'items/data', 'categories', 'users', 'reports', 'reports/excel', 'reports/pdf', 'settings', 'profile'] as $path) {
            $this->get('/'.$path)->assertForbidden();
        }
        $this->get(route('pos.receipt', $transaction))->assertForbidden();
        $this->get(route('pos.receipt.pdf', $transaction))->assertForbidden();
        $this->get(route('sales.daily'))->assertOk()->assertDontSee($transaction->invoice_code);
    }

    public function test_admin_pages_and_exports_render(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $item = $this->item();
        $this->post(route('pos.checkout'), $this->payload($item));
        foreach (['dashboard', 'items', 'items/create', 'categories', 'users', 'users/create', 'settings', 'reports', 'pos', 'sales/daily'] as $path) {
            $this->get('/'.$path)->assertOk();
        }
        $this->get(route('items.edit', $item))->assertOk();
        $this->getJson(route('items.data', ['draw' => 1, 'start' => 0, 'length' => 10, 'search' => ['value' => 'Teh']]))->assertOk()->assertJsonPath('recordsFiltered', 1);
        $this->get(route('reports.excel'))->assertOk()->assertDownload();
        $this->get(route('reports.pdf'))->assertOk()->assertHeader('content-type', 'application/pdf');
        $this->get(route('pos.receipt.pdf', Transaction::firstOrFail()))->assertOk()->assertHeader('content-type', 'application/pdf');
    }

    public function test_category_archive_preserves_history_and_hides_products(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $item = $this->item();
        $this->post(route('pos.checkout'), $this->payload($item));
        $this->delete(route('categories.destroy', $item->category))->assertRedirect();
        $this->assertSoftDeleted($item);
        $this->assertDatabaseCount('transaction_details', 1);
        $this->getJson(route('pos.items'))->assertExactJson([]);
        $this->get(route('pos.receipt', Transaction::firstOrFail()))->assertOk();
    }

    public function test_report_date_filters_and_validation(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $item = $this->item();
        $this->post(route('pos.checkout'), $this->payload($item));
        $this->get(route('reports.index', ['start_date' => today()->subDay()->format('Y-m-d'), 'end_date' => today()->subDay()->format('Y-m-d')]))->assertViewHas('count', 0);
        $this->getJson(route('reports.index', ['start_date' => '2026-12-01', 'end_date' => '2026-11-01']))->assertUnprocessable();
    }
}
