<div x-data>
    <div>
        <p class="text-xl text-gray-700">Talla:</p>

        <select class="form-control w-full" wire:model="size_selected">
            <option value="" selected disabled>Seleccione una talla</option>
            @foreach ($sizes as $size)
                <option value="{{ $size->id }}">{{ $size->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="mt-2">
        <p class="text-xl text-gray-700">Color:</p>

        <select class="form-control w-full" wire:model="color_selected">
            <option value="" selected disabled>Seleccione un color</option>
            @foreach ($colors as $color)
                <option value="{{ $color->id }}">{{ $color->name}}</option>
            @endforeach
        </select>
    </div>

    <div class="flex mt-4">
        <div class="mr-4">
            <x-jet-secondary-button disabled
                x-bind:disabled="$wire.qty <= 1" 
                wire:loading.attr="disabled"
                wire:target="decrement"
                wire:click="decrement"> - </x-jet-secondary-button>
            <span class="mx-2 text-gray-700"> {{ $qty }}</span>
            <x-jet-secondary-button 
                x-bind:disabled="$wire.qty >= $wire.stock" 
                wire:loading.attr="disabled"
                wire:target="increment"
                wire:click="increment"> + </x-jet-secondary-button>
        </div>

        <div class="flex-1">
            <x-button x-bind:disabled="!$wire.stock" color="orange" class="w-full"> Agregra al carrito de compras</x-button>
        </div>
    </div>
</div>
