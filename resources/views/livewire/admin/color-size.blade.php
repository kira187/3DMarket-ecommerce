<div class="card-body b-t collapse show">    
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form group @error('color_id') has-danger @enderror">
                        <x-jet-label> Color </x-jet-label>
                        <select class="form-control" wire:model.defer="color_id">
                            <option value="" selected hidden>Seleccione un color</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}">{{ ucfirst($color->name) }}</option>
                            @endforeach
                        </select>
                        @error('color_id')
                            <small class="form-control-feedback" role="alert">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group @error('quantity') has-danger @enderror">
                        <label class="control-label">Stock</label>
                        <input type="number" class="form-control  @error('quantity') form-control-danger @enderror" wire:model="quantity">
                        @error('quantity')
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
        </div>
    </div>

    @if (count($size_colors))
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">Color</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($size_colors as $index => $size_color)
                            
                                <tr wire:key="product-color-size-{{ $size_color->pivot->id }}">
                                    <td class="text-center">
                                        @if ($editedProductIndex !== $size_color->pivot->id)
                                            {{ $colors->find($size_color->pivot->color_id)->name }}
                                        @else
                                            <select class="form-control" wire:model.defer="pivot_color_id" disabled>
                                                <option value="" selected hidden disabled>Seleccione un color</option>
                                                @foreach ($colors as $color)
                                                    <option value="{{ $color->id }}">{{ ucfirst($color->name) }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($editedProductIndex !== $size_color->pivot->id)
                                            {{ $size_color->pivot->quantity }} unidades</td>
                                        @else
                                        <div class="form-group @error('pivot_quantity') has-danger @enderror">
                                            <input type="number" placeholder="Ingrese una cantidad" class="form-control" wire:model.defer="pivot_quantity">
                                            @error('pivot_quantity')
                                                <small class="form-control-feedback" role="alert">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>
                                        @endif
                                    <td class="text-center">
                                        @if ($editedProductIndex !== $size_color->pivot->id)
                                            <button 
                                                class="ml-auto mr-2 btn btn-secondary" 
                                                wire:click.prevent="editProduct({{ $size_color->pivot->id }})">
                                                Editar
                                            </button>
    
                                            <button class="btn btn-danger" wire:click="deletePivotId({{ $size_color->pivot->id }})">
                                                Eliminar
                                            </button>
                                        @else
                                            <button 
                                                class="ml-auto mr-2 btn btn-secondary" 
                                                wire:click.prevent="updateProduct({{ $size_color->pivot->id }})">
                                                Actualizar
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    
    <x-jet-dialog-modal wire:model="openModal">
        <x-slot name="title"> Editar colores </x-slot>
        <x-slot name="content"> 
            <div class="mb-4">
                <x-jet-label> Color </x-jet-label>
                <select class="form-control w-full" wire:model="pivot_color_id">
                    <option value="" selected hidden disabled>Seleccione un color</option>
                    @foreach ($colors as $color)
                        <option value="{{ $color->id }}">{{ ucfirst($color->name) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <x-jet-label> Cantidad </x-jet-label>
                <x-jet-input type="number" placeholder="Ingrese una cantidad" class="form-control" wire:model="pivot_quantity"/>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button 
                class="ml-auto mr-2" 
                wire:click="$set('openModal', false)">
                Cancelar
            </x-jet-secondary-button>

            <x-jet-button 
                wire:click="update"
                wire:loading.attr="disabled"
                wire:target="update">
                Actualizar
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>

    <x-jet-confirmation-modal wire:model="confirmingPivotDeletion">
        <x-slot name="title"> Eliminar producto </x-slot>    
        <x-slot name="content"> Estas seguro de eliminar este producto? </x-slot>    
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingPivotDeletion')" wire:loading.attr="disabled">
                Coservarlo
            </x-jet-secondary-button>
    
            <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
                Eliminarlo
            </x-jet-danger-button>
        </x-slot>        
    </x-jet-confirmation-modal>
</div>
