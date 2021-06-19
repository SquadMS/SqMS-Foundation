<?php

namespace SquadMS\Foundation\Admin\Http\Livewire\Contracts;

use Illuminate\Support\Arr;
use Livewire\Component;

abstract class AbstractModalsComponent extends Component
{
    public array $modals = [];

    /**
     * Toggles the modal visibility state.
     *
     * @return void
     */
    public function toggleModal(mixed $identifier, ?bool $state = null, ?array $action = null): void
    {
        /* Flip the current state if none is provided */
        if (is_null($state)) {
            $state = !Arr::get($this->modals, $identifier, false);
        }

        /* Set the modal visibility state */
        Arr::set($this->modals, $identifier, $state);

        /* Check if an component action should be called */
        if ($action) {
            /* Get the method and params form the defined action parameter */
            $method = Arr::get($action, 'action');
            $params = Arr::get($action, 'params', []);

            /* Execute the action */
            call_user_func_array($this->$method, $params);
        }
    }
}
