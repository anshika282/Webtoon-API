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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('webtoon_id');
            $table->string('c_name');
            $table->enum('role',['main', 'supporting', 'antagonist']);
            $table->text('summary')->nullable();
            $table->string('image')->nullable();     
            $table->timestamps();

            $table->foreign('webtoon_id')->references('id')->on('series')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
