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
        Schema::create('reviews', function (Blueprint $table) {
           $table->id();
           $table->unsignedBigInteger('course_id');
           $table->unsignedBigInteger('user_id');

           $table->foreign('course_id')->references('id')->on('courses')->cascadeOnUpdate()->cascadeOnDelete();
           $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();

           $table->text('comment');
           $table->string('rating');
           $table->integer('instructor_id')->nullable();
           $table->string('status')->default(0);


           $table->timestamp('created_at')->useCurrent();
           $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
