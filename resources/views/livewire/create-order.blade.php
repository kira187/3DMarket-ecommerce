<div class="container py-8 grid grid-cols-5 gap-6">
    <div class="col-span-3">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="mb-4">
                <x-jet-label value="Nombre de contacto" />
                <x-jet-input wire:model.defer="contact" type="text" placeholder="Ingrese el nombre de la persona que recibirá el producto"  class="w-full"/>
                <x-jet-input-error for="contact"/>
            </div>
            <div>
                <x-jet-label value="Teléfono de contacto" />
                <x-jet-input wire:model.defer="phone" type="text" placeholder="Ingrese el telefono de la persona que recibirá el producto"  class="w-full"/>
                <x-jet-input-error for="phone"/>
            </div>
        </div>

        <div x-data="{ envio_type : @entangle('envio_type') }">
            <p class="mt-6 mb-3 text-lg text-gray-700 font-semibold">Envios</p>
            <label class="bg-white rounded-lg shadow px-6 py-4 flex items-center mb-4 cursor-pointer"> 
                <input x-model="envio_type" type="radio" value="1" name="envio_type" class="text-gray-600">
                <span class="ml-2 text-gray-700">Recojo en tienda (Domicilio del local #23)</span>
                <span class="font-semibold text-gray-700 uppercase ml-auto"> Gratis </span>
            </label>

            <div class="bg-white rounded-lg shadow">
                <label class="px-6 py-4 flex items-center cursor-pointer"> 
                    <input x-model="envio_type" type="radio" value="2" name="envio_type" class="text-gray-600">
                    <span class="ml-2 text-gray-700">Envío a domicilio</span>
                </label>

                <div class="px-6 pb-6 grid grid-cols-2 gap-6 hidden" :class="{ 'hidden': envio_type != 2 }">
                    {{-- Departments --}}
                    <div>
                        <x-jet-label value="Departamento" />
                        <select class="form-control w-full" wire:model="department_id">
                            <option value="" disabled selected hidden>Seleccione un departamento</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="department_id"/>
                    </div>
                    {{-- Cities --}}
                    <div>
                        <x-jet-label value="Ciudad" />
                        <select class="form-control w-full" wire:model="city_id">
                            <option value="" disabled selected hidden>Seleccione una ciudad</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="city_id"/>
                    </div>
                    {{-- Districts --}}
                    <div>
                        <x-jet-label value="Distrito" />
                        <select class="form-control w-full" wire:model="district_id">
                            <option value="" disabled selected hidden>Seleccione un distrito</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="district_id"/>
                    </div>

                    <div>
                        <x-jet-label value="Dirección" />
                        <x-jet-input class="w-full" wire:model="address" type="text" />
                        <x-jet-input-error for="address"/>
                    </div>

                    <div class="col-span-2">
                        <x-jet-label value="Referencia" />
                        <x-jet-input class="w-full" wire:model="references" type="text" />
                        <x-jet-input-error for="references"/>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <x-jet-button class="mt-6 mb-4" wire:click="createOrder" wire:loading.attr="disable" wire:target="createOrder">
                Continuar con la compra
            </x-jet-button>
            <hr>
            <p class="mt-4 text-sm text-gray-700">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae amet doloribus iure distinctio voluptas rerum fugit! Quidem est suscipit aspernatur, dolores aliquid eveniet magni eius sequi qui nam, perferendis repellat. <a href="#" class="text-orange-500 font-semibold">Políticas y privacidad</a></p>
        </div>
    </div>
    <div class="col-span-2">
        <div class="card p-6">
            <ul>
                @forelse (Cart::content() as $item)
                    <li class="flex p-2 border-gray-200">
                        <img class="h-15 w-20 object-cover mr-4 rounded" src="{{ $item->options->image }}" alt="">
    
                        <article class="flex-1">
                            <h1 class="font-bold">{{ $item->name }}</h1>
    
                            <div class="flex">
                                <p> Cant: {{ $item->qty }}</p>
                                @isset($item->options['color'])
                                    <p class="mx-2">Color: {{ $item->options['color'] }} </p>
                                @endisset
    
                                @isset($item->options['size'])
                                <p> {{ $item->options['size'] }} </p>
                                @endisset
                            </div>
                            <p>MXN ${{ $item->price }}</p>
                        </article>
                    </li>
                @empty
                    <li class="py-6 px-4">
                        <p  class="text-center text-gray-700">Tu carrito está vacío</p>
                    </li>   
                @endforelse
            </ul>

            <hr class="mt-4 mb-3">
            <div class="text-gray-700">
                <p class="flex justify-between items-center">
                    Subtotal <span class="font-semibold">$ {{ Cart::subtotal() }}</span>
                </p>
                <p class="flex justify-between items-center">
                    Envío 
                    <span class="font-semibold">
                        @if ($envio_type == 1 || $shipping_cost == 0)
                            Gratis
                        @else
                            $ {{ $shipping_cost }}                            
                        @endif
                    </span>
                </p>

                <hr class="mt-4 mb-3">
                <p class="flex justify-between items-center font-semibold">
                    <span class="text-lg">Total</span>
                    @if ($envio_type == 1)
                        $ {{ Cart::subtotal() }}
                    @else
                    $ {{ Cart::subtotal() + $shipping_cost }}
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
