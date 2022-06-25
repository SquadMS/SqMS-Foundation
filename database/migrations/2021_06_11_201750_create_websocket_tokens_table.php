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
        Schema::create('websocket_tokens', function (Blueprint $table) {
            $table->id();

            /* The Session related to this token  */
            $table->string('session_id');
            $table->foreign('session_id')->references('id')->on('sessions')->cascadeOnDelete();

            /* The User related to the token */
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();

            /* The actual Token */
            $table->string('token')->unique();

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
        Schema::dropIfExists('websocket_tokens');
    }
};
