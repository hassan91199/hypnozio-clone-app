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
        Schema::create('quiz_submissions', function (Blueprint $table) {
            $table->id();

            $table->string('email')->unique();

            $table->string("answer_1")->nullable();
            $table->string("answer_2")->nullable();
            $table->string("answer_4")->nullable();
            $table->string("answer_5")->nullable();
            $table->string("answer_6")->nullable();
            $table->string("answer_8")->nullable();
            $table->string("answer_9")->nullable();
            $table->string("answer_10")->nullable();
            $table->string("answer_11")->nullable();
            $table->string("answer_13")->nullable();
            $table->string("answer_15")->nullable();
            $table->string("answer_17")->nullable();
            $table->string("answer_18")->nullable();
            $table->string("answer_19")->nullable();
            $table->string("answer_20")->nullable();
            $table->string("answer_22")->nullable();
            $table->string("answer_23")->nullable();

            $table->string("height")->nullable();
            $table->string("weight")->nullable();
            $table->string("desired_weight")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_submissions');
    }
};
