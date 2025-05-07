<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('business_owners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('customer_group_id')->nullable(); // JSON field for customer groups
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_owners');
    }
};
