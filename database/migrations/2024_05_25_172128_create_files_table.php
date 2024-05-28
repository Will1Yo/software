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
        Schema::create('files', function (Blueprint $table) {
            $table->id('id');
            $table->string('files', length: 150);
            $table->string('ruta', length: 200);
            $table->string('path', length: 500);
            $table->text('update_comment')->nullable();
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
        Schema::dropIfExists('files');
    }
};
