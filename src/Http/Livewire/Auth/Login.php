<?php

namespace SquadMS\Foundation\Http\Livewire\Auth;

use Filament\Http\Livewire\Auth\Login as BaseLogin;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\View as ViewFacade;

class Login extends BaseLogin
{
    public function render(): View
    {
        return ViewFacade::make('sqms-foundation::login')
            ->layout('filament::components.layouts.card', [
                'title' => __('filament::login.title'),
            ]);
    }
}
