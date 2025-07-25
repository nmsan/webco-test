<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('type_assignments', function (Blueprint $table) {
            $table->id();
            $table->string('type_assignments_type');
            $table->unsignedBigInteger('type_assignments_id')->nullable(); // Changed to nullable()
            $table->unsignedBigInteger('product_type_id');
            $table->string('my_bonus_field', 255)->nullable();
            $table->timestamps();

            $table->foreign('product_type_id')->references('id')->on('product_types')->onDelete('cascade');
            $table->index(['type_assignments_type', 'type_assignments_id'], 'morph_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('type_assignments');
    }
};
