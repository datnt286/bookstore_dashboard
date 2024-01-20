<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->string('name');
            $table->string('phone', 10);
            $table->string('address')->nullable();
            $table->integer('total');
            $table->integer('shipping_fee')->nullable();
            $table->integer('total_payment')->nullable();
            $table->string('note')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('payment_method')->default(0);
            $table->tinyInteger('payment_status')->default(0);
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('admin_id')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
