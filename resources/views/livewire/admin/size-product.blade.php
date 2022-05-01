<div class="row">

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="container">
                    <h3 class="box-title">Stock del producto</h3>
                    <div class="row m-t-20">
                        <div class="col-lg-12">
                            <div class="form-group @error('name') has-danger @enderror">
                                <x-jet-label> Talla </x-jet-label>
                                <input type="text" class="form-control @error('name') form-control-danger @enderror" wire:model="name">
                                @error('name')
                                    <small class="form-control-feedback" role="alert">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-right">
                            <button class="btn btn-info"
                                wire:loading.attr="disabled"
                                wire:target="save"
                                wire:click="save">
                                Agregar
                            </button>
                        </div>
                    </div>
                    <div class="m-t-15">
                        @foreach ($sizes as $size)                        
                            <div class="card earning-widget" wire:key="size-{{ $size->id }}">
                                <div class="card-header">
                                    <div class="card-actions">                                                
                                        <a class="btn btn-secondary" data-action="collapse"><i class="ti-minus"></i></a>
                                        <button class="btn btn-muted"
                                            data-toggle="modal" data-target="#editTalla" 
                                            wire:click="edit({{ $size->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="edit({{ $size->id }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger" wire:click="deletePivotId({{ $size->id }})" data-toggle="modal" data-target="#deleteTalla" >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <h4 class="card-title m-b-0">{{ $size->name }}</h4>
                                </div>
                                <livewire:admin.color-size :size="$size" :wire:key="'color-size-'.$size->id"/>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

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
