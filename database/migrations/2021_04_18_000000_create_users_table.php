<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            /* Steam Account ID */
            $table->string('password')->default(Config::get('sqms.user.default-password', 'DefaultUserPassword'));

            /* Steam Account ID */
            $table->string('steam_account_id')->unique();

            /* Steam Account ID */
            $table->string('steam_account_url')->unique();

            /* SteamID */
            $table->string('steam_id_64')->unique();
            $table->string('steam_id_2')->unique();
            $table->string('steam_id_3')->unique();

            /* Avatar */
            $table->string('avatar')->default(asset(Config::get('sqms.user.defaults.avatar.full')));
            $table->string('avatar_medium')->default(asset(Config::get('sqms.user.defaults.avatar.medium')));
            $table->string('avatar_small')->default(asset(Config::get('sqms.user.defaults.avatar.small')));

            /* Username */
            $table->string('name')->default('No Username :(');

            /* Account URL */
            $table->string('account_url')->default('#');

            /* SteamAPI last fetched timestamp */
            $table->timestamp('last_fetched')->nullable();

            /* User specific locale */
            $table->string('locale')->default(Config::get('app.locale', 'en'));

            /* Auth remember token */
            $table->rememberToken();

            /* API-Token */
            $table->string('api_token', 80)->unique()->nullable()->default(null);

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
        Schema::dropIfExists('users');
    }
}
