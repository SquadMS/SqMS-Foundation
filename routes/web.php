<?php

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use SquadMS\Foundation\Http\Controllers\HomeController;

/* Home Page */
Route::get('/', [HomeController::class, 'show'])->name('home');

/* User Profile */
Route::get(Config::get('sqms.user.route.url') . '/{steam_id_64}', [Config::get('sqms.user.route.controller'), 'show'])->name(Config::get('sqms.user.route.name'));

/* SteamLogin */
Route::get('steam/login', [Config::get('sqms.auth.controller'), 'login'])->name(Config::get('sqms.auth.routes.login'));
Route::get('steam/auth', [Config::get('sqms.auth.controller'), 'authenticate'])->name(Config::get('sqms.auth.routes.auth'));