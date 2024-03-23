<?php

use App\Models\Division;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('ein', 6);
            $table->string('name', 50);
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('assessor_id')->nullable();
            $table->string('gender', 100);
            $table->string('age', 100);
            $table->string('country', 100);
            $table->string('city', 100);
            $table->string('anual_salary', 100);
            $table->string('job_title', 100);
            $table->double('value')->default(0);
            $table->integer('rangking')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('division_id')->references('id')->on('divisions')->cascadeOnDelete();
            $table->foreign('assessor_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};