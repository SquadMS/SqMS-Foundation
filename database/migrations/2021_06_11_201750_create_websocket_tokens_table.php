<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsocketTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('websocket_tokens', function (Blueprint $table) {
            /* The Session related to this token  */
            $table->string('session_id')->references('id')->on('sessions')->onDelete('cascade');

            /* The User related to the token */
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');

            /* The actual Token */
            $table->string('token')->unique();
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
}
