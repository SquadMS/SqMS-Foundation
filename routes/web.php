<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

/* User Profile */
Route::get(Config::get('sqms.user.route.url') . '/{steam_id_64}', [Config::get('sqms.user.route.controller'), 'show'])->name(Config::get('sqms.user.route.name'));

/* SteamLogin */
Route::get('steam/login', [Config::get('sqms.auth.controller'), 'login'])->name('steam.login');
Route::get('steam/auth', [Config::get('sqms.auth.controller'), 'authenticate'])->name('steam.auth');