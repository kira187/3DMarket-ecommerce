<div>
    <div class="card p-6 mt-12">
        <div>
            <x-jet-label> Talla </x-jet-label>
            <x-jet-input wire:model.defer="name" type="text" class="w-full" flaceholder="Ingrese una talla" />
            <x-jet-input-error for="name"/>
        </div>
        <div class="flex justify-end items-center mt-4">
            <x-jet-button 
                wire:click="save"
                wire:loading.attr="disabled"
                wire:target="save"> Agregar </x-jet-button>
        </div>
    </div>

    <ul class="mt-12 space-y-4">
        @foreach ($sizes as $size)
            <li class="bg-white shadow-lg rounded-lg p-6" wire:key="size-{{ $size->id }}">
                <div class="flex items-center">
                    <span class="text-xl font-medium">{{ $size->name }}</span>
                    <div class="ml-auto">
                        <x-jet-button
                            wire:click="edit({{ $size->id }})"
                            wire:loading.attr="disabled"
                            wire:target="edit({{ $size->id }})">
                            <i class="fas fa-edit"></i>
                        </x-jet-button>

                        <x-jet-danger-button wire:click="$emit('deleteSize', {{ $size->id }})">
                            <i class="fas fa-trash"></i>
                        </x-jet-danger-button>
                    </div>
                </div>
                <livewire:admin.color-size :size="$size" :wire:key="'color-size-'.$size->id"/>
            </li>
        @endforeach
    </ul>

    <x-jet-dialog-modal wire:model="openModal">
        <x-slot name="title"> Editar talla </x-slot>
        <x-slot name="content">
            <x-jet-label> Talla </x-jet-label>
            <x-jet-input type="text" class="w-full" wire:model.defer="name_edit"/>
            <x-jet-input-error for="name_edit" />
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('openModal', false)" class="mr-2">  Cancelar  </x-jet-secondary-button>
            <x-jet-button 
                wire:click="update"
                wire:loading.attr="disable"
                wire:target="update">
                Actualizar  
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
