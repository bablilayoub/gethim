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
        Schema::create('clicks', function (Blueprint $table) {
            $table->id();
            $table->string('link_token');
            $table->string('user_token');
            $table->string('user_agent')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('referer')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
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
        Schema::dropIfExists('clicks');
    }
};
