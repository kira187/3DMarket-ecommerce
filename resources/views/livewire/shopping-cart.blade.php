<div class="container py-8">
    <section class="bg-white rounded-lg shadow-lg p-6 text-gray-700">
        <h1 class="text-lg font-semibold mb-6">CARRO DE COMPRAS</h1>

        @if (Cart::count())    
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th></th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (Cart::content() as $item)
                        <tr>
                            <td>
                                <div class="flex">
                                    <img class="h-15 w-20 object-cover mr-4 rounded" src="{{ $item->options->image }}" alt="">
                                    <div>
                                        <p class="font-bold">{{ $item->name }}</p>
                                        
                                        @if ($item->options->color)
                                            <span>
                                                Color: {{ $item->options->color }}
                                            </span>
                                        @endif
                                        
                                        @if ($item->options->size)
                                            <span class="mx-1">-</span>
                                            <span>
                                                Talla: {{ $item->options->size }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="text-center"> 
                                <span> $ {{ $item->price }}</span>
                                <a class="ml-6 cursor-pointer hover:text-red-600 transition" 
                                    wire:click="deleteItem('{{ $item->rowId }}')"
                                    wire:loading.class="text-red-600 opacity-25"
                                    wire:target="deleteItem('{{ $item->rowId }}')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                            <td>
                                <div class="flex justify-center">
                                    @if ($item->options->size)
                                        <livewire:update-cart-item-size :rowId="$item->rowId" :wire:key="$item->rowId"/>
                                    @elseif($item->options->color)
                                        <livewire:update-cart-item-color :rowId="$item->rowId" :wire:key="$item->rowId"/>
                                    @else
                                        <livewire:update-cart-item :rowId="$item->rowId" :wire:key="$item->rowId"/>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">$ {{ $item->price * $item->qty}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a class="text-sm hover:cursor-pointer hover:underline mt-3 inline-block" wire:click="destroyCart">
                <i class="fas fa-trash"></i>
                Borrar carrito de compras
            </a>
        @else
            <div class="flex flex-col items-center">
                <x-cart />
                <p class="text-lg text-gray-700 mt-4 uppercase">Tu carro de compras se encuentra vacio</p>
                <x-button-enlace href="/" class="mt-4">
                    Ir al inicio
                </x-button-enlace>
            </div>
        @endif
    </section>

    @if (Cart::count())
        <div class="bg-white rounded-lg shadow-lg px-6 py-4 mt-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray">
                        <span class="font-bold text-lg">Total:</span>
                        $ {{ Cart::subTotal() }}
                    </p>
                </div>

                <div>
                    <x-button-enlace color="orange" class="cursor-pointer" href="{{ route('orders.create')}}">
                        Continuar
                    </x-button-enlace>
                </div>
            </div>
        </div>
    @endif
</div>
