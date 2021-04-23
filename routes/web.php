<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;

/* Define routes from config */
foreach (config('sqms.routes.def') as $definition) {
    $type = Arr::get($definition, 'type', 'get');
    Route::$type(Arr::get($definition, 'path', '/'), [Arr::get($definition, 'controller'), Arr::get($definition, 'executor', 'show')])->middleware(Arr::get($definition, 'middlewares'))->name(Arr::get($definition, 'name'));
}