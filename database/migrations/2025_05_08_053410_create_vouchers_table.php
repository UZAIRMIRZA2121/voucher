<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('language')->default('EN');
            $table->string('voucher_name');
            $table->text('voucher_description');
            $table->string('item_image')->nullable();
            $table->string('item_thumbnail')->nullable();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->text('nutrition')->nullable();
            $table->text('allergen_ingredients')->nullable();
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('provider_id');
            $table->enum('discount_type', ['Percentage', 'Fixed', 'Cash Back', 'Gift', 'Bundle', 'Free Delivery']);
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('minimum_purchase', 10, 2)->nullable();
            $table->decimal('maximum_discount', 10, 2)->nullable();
            $table->integer('limit_per_user')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->time('daily_start_time')->nullable();
            $table->time('daily_end_time')->nullable();
            $table->json('addon_ids')->nullable();
            $table->json('voucher_options')->nullable();
            $table->json('food_variations')->nullable();
            $table->json('tags')->nullable();
            $table->set('payment_methods', ['Cash', 'Wallet', 'Electronic'])->nullable();
            $table->set('offer_receiving_methods', ['Delivery', 'Takeaway', 'In-store'])->nullable();
            $table->string('qr_code')->nullable();
            $table->string('barcode')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
