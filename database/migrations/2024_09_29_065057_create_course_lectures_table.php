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
        Schema::create('course_lectures', function (Blueprint $table) {
           $table->id();
           $table->string('lecture_title')->nullable();
           $table->string('video')->nullable();
           $table->text('url')->nullable();
           $table->longText('content')->nullable();

           $table->unsignedBigInteger('course_id')->nullable();
           $table->unsignedBigInteger('section_id');

           $table->foreign('course_id')->references('id')->on('courses')->cascadeOnUpdate()->cascadeOnDelete();
           $table->foreign('section_id')->references('id')->on('course_sections')->cascadeOnUpdate()->cascadeOnDelete();


           $table->timestamp('created_at')->useCurrent();
           $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_lectures');
    }
};
