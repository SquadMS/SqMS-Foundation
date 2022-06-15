@extends('sqms-foundation::templates.page', [
    'title' => __('sqms-foundation::pages/profile.heading', ['name' => $user->name . '('. $user->steam_id_64 . ')'])
])