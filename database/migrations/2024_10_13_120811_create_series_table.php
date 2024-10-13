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
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('author_id');
            $table->text('description')->nullable();
            // $table->unsignedBigInteger('genre_id');
            $table->string('thumbnail')->nullabale();
            $table->enum('status',['ongoing', 'completed', 'on hiatus']);
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('author')->onDelete('cascade');

            // $table->foreign('genre_id')->references('id')->on('genres')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
