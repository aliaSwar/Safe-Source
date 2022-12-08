<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->comment('File Table');
            $table->id();
            $table->text('path');
            $table->string('name')->unique();
            $table->string('slug');
            $table->boolean('is_reserve')->default(false);
            $table->unsignedBigInteger('user_id');
            $table->index('is_reserve');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
};