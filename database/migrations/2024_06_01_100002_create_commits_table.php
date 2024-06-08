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
        Schema::create('commits', function (Blueprint $table) {
            $table->id('id');
            $table->text('update_comment');
            $table->integer('commit');
            $table->string('ruta', length: 200);
            $table->unsignedBigInteger('id_files'); 
            $table->foreign('id_files')->references('id')->on('files')->onDelete('cascade');
            $table->unsignedBigInteger('id_repo'); 
            $table->foreign('id_repo')->references('id')->on('repositories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commits');
    }
};
