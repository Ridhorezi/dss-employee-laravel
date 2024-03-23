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
        Schema::create('subcriterias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('criteria_id');
            $table->tinyInteger('order');
            $table->string('name', 50);
            $table->double('comparison_column_sum')->default(0);
            $table->double('normalization_row_sum')->default(0);
            $table->double('priority')->default(0);
            $table->double('eigen')->default(0);
            $table->double('alternative_column_sum')->default(0);
            $table->timestamps();

            $table->foreign('criteria_id')->references('id')->on('criterias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcriterias');
    }
};
