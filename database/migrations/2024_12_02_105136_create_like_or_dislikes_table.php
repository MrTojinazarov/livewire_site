<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('like_or_dislikes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
            $table->ipAddress('user_ip');
            $table->boolean('value');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('like_or_dislikes');
    }
};
