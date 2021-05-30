<div class="d-inline-block text-start">
    <x-sqms-foundation::button class="btn-primary" wire:click="$toggle('showModal')" wire:loading.attr="disabled">
        Create
    </x-sqms-foundation::button>

    <x-sqms-foundation::dialog-modal model="showModal">
        <x-slot name="title">
            Create Role
        </x-slot>
    
        <x-slot name="content">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="New role name" aria-label="New role name" wire:model.lazy="input">
            </div>
        </x-slot>
    
        <x-slot name="footer">
            <x-sqms-foundation::button class="btn-dark" wire:click="$set('showModal', false)" wire:loading.attr="disabled">
                Cancel
            </x-sqms-foundation::button>
    
            <div class="flex-grow-1"></div>

            <x-sqms-foundation::button class="btn-success" wire:click="createRole" wire:loading.attr="disabled">
                Create
            </x-sqms-foundation::button>
        </x-slot>
    </x-sqms-foundation::dialog-modal>
</div>