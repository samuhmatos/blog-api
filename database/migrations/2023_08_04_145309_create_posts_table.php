<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $dependsOn = [
        
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title',150)->unique();
            $table->string('sub_title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->string('image_url');
            $table->integer('views')->default(0);
            //$table->string('tags')->nullable();
            $table->foreignId('category_id')->references('id')->on('post_categories')->cascadeOnDelete();
            $table->foreignId('author_id')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
