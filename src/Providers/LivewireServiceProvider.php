<?php

namespace SquadMS\Foundation\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use SquadMS\Foundation\Admin\Http\Livewire\RBAC\CreateRole;
use SquadMS\Foundation\Admin\Http\Livewire\RBAC\DeleteRole;
use SquadMS\Foundation\Admin\Http\Livewire\RBAC\EditRole;
use SquadMS\Foundation\Admin\Http\Livewire\RBAC\MembersRole;
use SquadMS\Foundation\Admin\Http\Livewire\RBAC\NewMemberSearch;
use SquadMS\Foundation\Admin\Http\Livewire\RBAC\RoleEntry;
use SquadMS\Foundation\Admin\Http\Livewire\RBAC\RoleList;

class LivewireServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /* Register livewire components */
        Livewire::component('sqms-foundation.admin.rbac.new-member-search', NewMemberSearch::class);
        Livewire::component('sqms-foundation.admin.rbac.role-list', RoleList::class);
        Livewire::component('sqms-foundation.admin.rbac.create-role', CreateRole::class);
    }
}
