<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use SquadMS\Foundation\Auth\Http\Controllers\SteamLoginController;

/* User Profile */
Route::get(Config::get('sqms.user.route.url'), [Config::get('sqms.user.route.controller'), 'show'])->name(Config::get('sqms.user.route.name'));

/* SteamLogin */
Route::get('steam/login', [Config::get('sqms.auth.controller'), 'login'])->name('steam.login');
Route::get('steam/auth', [SteamLoginController::class, 'authenticate'])->name('steam.auth');