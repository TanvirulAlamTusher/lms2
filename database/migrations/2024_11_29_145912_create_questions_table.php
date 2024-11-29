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
        Schema::create('questions', function (Blueprint $table) {
          $table->id();


          $table->unsignedBigInteger('course_id')->nullable();
          $table->unsignedBigInteger('user_id')->nullable();
          $table->unsignedBigInteger('instructor_id')->nullable();


          $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate();
          $table->foreign('course_id')->references('id')->on('courses')->cascadeOnUpdate();
          $table->foreign('instructor_id')->references('id')->on('users')->cascadeOnUpdate();


          $table->integer('parent_id')->nullable();
          $table->text('subject')->nullable();
          $table->text('question');

          $table->timestamp('created_at')->useCurrent();
          $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
