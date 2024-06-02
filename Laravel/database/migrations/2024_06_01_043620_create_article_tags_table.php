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
        Schema::create('article_tags', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('tags_id');
            $table->unsignedBigInteger('article_id');
            $table->string('articleTag');
            $table->timestamps();
            // $table
            //     ->foreign('tags_id')
            //     ->references('id')
            //     ->on('tags')
            //     ->onDelete('cascade');
            $table
                ->foreign('article_id')
                ->references('id')
                ->on('articles')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_tags');
    }
};
