<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('group_customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('business_owner_id')->constrained('business_owners')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_customers');
    }
};
