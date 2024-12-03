<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('title'); 
            $table->text('description'); 
            $table->text('text'); 
            $table->string('img')->nullable(); 
            $table->unsignedInteger('likes')->default(0); 
            $table->unsignedInteger('dislikes')->default(0); 
            $table->unsignedInteger('views')->default(0); 
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
