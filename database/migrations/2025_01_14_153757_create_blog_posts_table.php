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
        Schema::create('blog_posts', function (Blueprint $table) {
         $table->id();

         $table->unsignedBigInteger('blogcat_id');
         $table->foreign('blogcat_id')->references('id')
         ->on('blog_categories')->cascadeOnUpdate()->cascadeOnDelete();


         $table->string('post_title')->nullable();
         $table->string('post_slug')->nullable();
         $table->string('post_image')->nullable();
         $table->text('long_descp')->nullable();
         $table->string('post_tags')->nullable();


         $table->timestamp('created_at')->useCurrent();
         $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
