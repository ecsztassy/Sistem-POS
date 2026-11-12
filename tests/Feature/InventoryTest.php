<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    use RefreshDatabase;

    private function data(): array
    {
        return ['category_id' => Category::create(['name' => 'Minuman'])->id, 'item_code' => 'BRG-001', 'name' => 'Air Mineral', 'buy_price' => 3000, 'sell_price' => 4000, 'stock' => 20, 'unit' => 'botol'];
    }

    public function test_item_can_be_created_updated_and_archived(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $data = $this->data();
        $this->post(route('items.store'), $data)->assertSessionHasNoErrors()->assertRedirect(route('items.index'));
        $item = Item::firstOrFail();
        $this->put(route('items.update', $item), array_replace($data, ['stock' => 4]))->assertSessionHasNoErrors();
        $this->assertEquals(4, $item->fresh()->stock);
        $this->delete(route('items.destroy', $item))->assertRedirect();
        $this->assertSoftDeleted($item);
        $this->post(route('items.store'), $data)->assertSessionHasErrors('item_code');
    }

    public function test_negative_values_duplicate_codes_and_archived_categories_are_rejected(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']));
        $data = $this->data();
        foreach (['stock', 'buy_price', 'sell_price'] as $field) {
            $this->post(route('items.store'), array_replace($data, [$field => -1]))->assertSessionHasErrors($field);
        }
        Item::create($data);
        $this->post(route('items.store'), $data)->assertSessionHasErrors('item_code');
        Category::findOrFail($data['category_id'])->delete();
        $this->post(route('items.store'), array_replace($data, ['item_code' => 'BRG-002']))->assertSessionHasErrors('category_id');
        $this->assertDatabaseCount('items', 1);
    }

    public function test_admin_can_manage_users_without_removing_their_own_access(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->post(route('users.store'), ['name' => 'Kasir Baru', 'username' => 'kasirbaru', 'role' => 'kasir', 'password' => 'Password123!', 'password_confirmation' => 'Password123!'])->assertSessionHasNoErrors();
        $cashier = User::where('username', 'kasirbaru')->firstOrFail();
        $this->assertTrue(password_verify('Password123!', $cashier->password));
        $this->put(route('users.update', $admin), ['name' => $admin->name, 'username' => $admin->username, 'role' => 'kasir'])->assertSessionHasErrors('role');
        $this->delete(route('users.destroy', $admin))->assertSessionHasErrors('user');
        $this->delete(route('users.destroy', $cashier))->assertRedirect();
        $this->assertDatabaseMissing('users',['id' => $cashier->id]);
    }
}
