<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'kasir'])->default('kasir');
        });
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_code')->unique();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->unsignedBigInteger('buy_price');
            $table->unsignedBigInteger('sell_price');
            $table->integer('stock')->default(0);
            $table->string('unit')->default('pcs');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code')->unique();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->unsignedBigInteger('total_price');
            $table->unsignedBigInteger('pay_amount');
            $table->unsignedBigInteger('change_amount');
            $table->text('notes')->nullable();
            $table->uuid('checkout_token')->unique();
            $table->timestamps();
            $table->index('created_at');
        });
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained()->cascadeOnDelete();
            $table->foreignId('item_id')->constrained()->restrictOnDelete();
            $table->string('item_name');
            $table->string('item_code');
            $table->integer('qty');
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('buy_price');
            $table->unsignedBigInteger('subtotal');
            $table->timestamps();
        });
        Schema::create('store_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->string('phone');
            $table->text('footer_note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['transaction_details', 'transactions', 'items', 'categories', 'store_settings'] as $name) {
            Schema::dropIfExists($name);
        }
        Schema::table('users', fn (Blueprint $table) => $table->dropColumn('role'));
    }
};
