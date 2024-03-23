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
        Schema::create('subcriteria_comparisons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subcriteria_id');
            $table->tinyInteger('row_idx');
            $table->tinyInteger('column_idx');
            $table->double('value')->default(1);
            $table->double('normalization_value')->default(1);
            $table->timestamps();

            $table->foreign('subcriteria_id')->references('id')->on('subcriterias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcriteria_comparisons');
    }
};
