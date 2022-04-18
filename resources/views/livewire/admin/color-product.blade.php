<div>
    <div class="my-12 card p-6">
        {{-- Colors checbocx --}}
        <div class="mb-6">
            <x-jet-label value="Color" />
            <div class="grid grid-cols-6 gap-6">
                @foreach ($colors as $color)
                    <label>
                        <input wire:model.defer="color_id" type="radio" name="color_id" value="{{ $color->id }}">
                        <span class="ml-2 text-gray-700 capitalize">{{ $color->name }}</span>
                    </label>
                @endforeach
            </div>
            <x-jet-input-error  for="color_id" />
        </div>
        <div>
            <x-jet-label name="Cantidad"/>
            <x-jet-input wire:model.defer="quantity" type="number" placeholder="Ingrese una cantidad" class="w-full"/>
            <x-jet-input-error for="quantity" />
        </div>
        <div class="flex justify-end items-center mt-4">
            <x-jet-action-message class="mr-3" on="saved"> Agregado </x-jet-action-message>
                <x-jet-button 
                    wire:loading.attr="disabled"
                    wire:target="save"
                    wire:click="save">
                    Agregar
                </x-jet-button>
        </div>
    </div>

    @if (count($productsColors))
        <div class="card p-6">
            <table>
                <thead>
                    <tr>
                        <th class="px-4 py-2 w-1/3">Color</th>
                        <th class="px-4 py-2 w-1/3">Cantidad</th>
                        <th class="px-4 py-2 w-1/3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productsColors as $productColor)
                        <tr wire:key="product-color-{{ $productColor->pivot->id }}">
                            <td class="capitalize px-4 py-2"> {{ $colors->find($productColor->pivot->color_id)->name }}</td>
                            <td class="px-4 py-2">{{ $productColor->pivot->quantity }} unidades</td>
                            <td class="px-4 py-2 flex">
                                <x-jet-secondary-button 
                                    class="ml-auto mr-2" 
                                    wire:click="edit({{ $productColor->pivot->id }})"
                                    wire:loading.attr="disabled"
                                    wire:target="edit({{ $productColor->pivot->id }})">
                                    Actualizar
                                </x-jet-secondary-button>

                                <x-jet-danger-button wire:click="$emit('deletePivot', {{ $productColor->pivot->id }})">
                                    Eliminar
                                </x-jet-danger-button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
                <x-jet-input type="number" placeholder="Ingrese una cantidad" class="w-full" wire:model="pivot_quantity"/>
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
</div>
