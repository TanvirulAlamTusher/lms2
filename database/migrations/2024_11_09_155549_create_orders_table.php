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
        Schema::create('orders', function (Blueprint $table) {
         $table->id();

         $table->unsignedBigInteger('payment_id');
         $table->unsignedBigInteger('user_id')->nullable();
         $table->unsignedBigInteger('course_id')->nullable();
         $table->unsignedBigInteger('instructor_id')->nullable();

        
         $table->string('course_title')->nullable();
         $table->double('price')->nullable();

         $table->foreign('payment_id')->references('id')->on('payments')->cascadeOnUpdate()->cascadeOnDelete();
         $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate();
         $table->foreign('course_id')->references('id')->on('courses')->cascadeOnUpdate();
         $table->foreign('instructor_id')->references('id')->on('users')->cascadeOnUpdate();


         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
