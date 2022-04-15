<div class="mt-4">
    <div class="my-12 bg-gray-100 shadow-lg rounded-lg p-6">
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

    @if (count($size_colors))
    <div class="mt-8">
        <table>
            <thead>
                <tr>
                    <th class="px-4 py-2 w-1/3">Color</th>
                    <th class="px-4 py-2 w-1/3">Cantidad</th>
                    <th class="px-4 py-2 w-1/3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($size_colors as $size_color)
                    <tr wire:key="product-color-{{ $size_color->pivot->id }}">
                        <td class="capitalize px-4 py-2"> {{ $colors->find($size_color->pivot->color_id)->name }}</td>
                        <td class="px-4 py-2">{{ $size_color->pivot->quantity }} unidades</td>
                        <td class="px-4 py-2 flex">
                            <x-jet-secondary-button 
                                class="ml-auto mr-2" 
                                wire:click="edit({{ $size_color->pivot->id }})"
                                wire:loading.attr="disabled"
                                wire:target="edit({{ $size_color->pivot->id }})">
                                Actualizar
                            </x-jet-secondary-button>

                            <x-jet-danger-button wire:click="$emit('deletePivot', {{ $size_color->pivot->id }})">
                                Eliminar
                            </x-jet-danger-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
</div>
