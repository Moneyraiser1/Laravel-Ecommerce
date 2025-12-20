<?php

// database/migrations/2025_08_20_000001_create_orders_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('total', 10, 2);
            $table->string('payment_status')->default('pending'); // success/failed/pending
            $table->string('reference')->unique(); // Paystack reference
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('price', 10, 2); // price at purchase
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
