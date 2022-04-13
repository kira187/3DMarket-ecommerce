<div>
    @php
        // SDK de Mercado Pago
        require base_path('/vendor/autoload.php');
        // Agrega credenciales
        MercadoPago\SDK::setAccessToken(config('services.mercadopago.token'));

        // Crea un objeto de preferencia
        $preference = new MercadoPago\Preference();

        // Crea objeto de costo de envio
        $shipments = new MercadoPago\Shipments();
        $shipments->cost = $order->shipping_cost;
        $shipments->mode = "not_specified";
        $preference->shipments = $shipments;

        // Crea un ítem en la preferencia
        foreach ($items as $product) {
            $item = new MercadoPago\Item();
            $item->title = $product->name;
            $item->quantity = $product->qty;
            $item->unit_price = $product->price;

            $products[] = $item;
        }

        $preference->back_urls = array(
            "success" => route('orders.pay', $order),
            "failure" => route('orders.payment', $order),
            "pending" => route('orders.payment', $order)
        );
        $preference->auto_return = "approved";

        $preference->items = $products;
        $preference->save();
    @endphp

    <div class="grid grid-cols-5 gap-6 container py-8">
        <div class="col-span-3">
            <div class="card px-6 py-4">
                <p class="text-gray-700 uppercase">
                    <span class="font-semibold">Número de orden:</span> Orden-{{ $order->id }}
                </p>
            </div>
    
            <div class="card p-6 my-6">
                <div class="grid grid-cols-2 gap-6 text-gray-700">
                    <div>
                        <p class="text-lg font-semibold uppercase">Envío</p>
    
                        @if ($order->envio_type == 1)
                            <p class="text-sm">Los productos deben ser recogidos en tíenda</p>
                            <p class="text-sm">Calle falsa #123</p>
                        @else
                            <p class="text-sm">Los productos serán enviados a:</p>
                            <p class="text-sm">{{ $order->address }}</p>
                            <p class="text-sm">{{ $order->department->name }} - {{ $order->city->name }} - {{ $order->district->name }}</p>
                        @endif
                    </div>
                    
                    <div>
                        <p class="text-lg font-semibold uppercase">Datos de contacto</p>
                        <p class="text-sm">Persona que recibirá el producto: {{ $order->contact }}</p>
                        <p class="text-sm">Teléfono de contacto: {{ $order->phone }}</p>
                    </div>
                </div>
            </div>
    
            <div class="card p-6 text-gray-700">
                <p class="text-xl font-semibold mb-4">Resumen</p>
    
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($items as $item)    
                            <tr>
                                <td>
                                    <div class="flex">
                                        <img src="{{ $item->options->image }}" alt="" class="h-15 w-20 object-cover mr-4">
                                        <article>
                                            <h1 class="font-bold"> {{ $item->name }} </h1>
                                            <div class="flex text-xs">
                                                @isset($item->options->color)
                                                    Color: {{ $item->options->color }}
                                                @endisset
                                                
                                                @isset ($item->options->size)
                                                    Talla: {{ $item->options->size }}
                                                @endisset
                                            </div>
                                        </article>
                                    </div>
                                </td>
                                <td class="text-center">
                                    $ {{ $item->price }}
                                </td>
                                <td class="text-center">
                                    {{ $item->qty }}
                                </td>
                                <td class="text-center">
                                    {{ $item->price * $item->qty }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-span-2">
            <div class="card px-6 pt-6">
                <div class="flex justify-between items-center my-4">
                    <img class="h-8" src="{{ asset('img/MC_VI_DI_2-1.jpg') }}" alt="">
                    <div class="text-gray-700">
                        <p class="text-sm font-semibold ">
                            Subtotal: $ {{ $order->total - $order->shipping_cost }}
                        </p>
                        <p class="text-sm font-semibold">
                            Envio: {{ $order->shipping_cost <= 0 ? 'Gratis' : '$ '.$order->shipping_cost }}
                        </p>
                        <p class="text-lg font-semibold uppercase">
                            Pago: $ {{ $order->total }}
                        </p>
                    </div>
                </div>

                <div class="cho-container my-4 w-full"></div>
                <div id="paypal-button-container"></div>
                {{-- <button class="bg-blue-400 py-2 px-4 rounded inline-flex items-center w-full justify-center">
                    <img class="h-7" src="{{ asset('img/MP_LOGO.png') }}" alt="dummy-image">
                </button> --}}
            </div>
        </div>
    </div>

    @push('script')    
        {{-- Mercado pago Pasarela de pago --}}
        <script src="https://sdk.mercadopago.com/js/v2"></script>
        <script>
            // Agrega credenciales de SDK
            const mp = new MercadoPago("{{ config('services.mercadopago.key') }}", {
            locale: "es-AR",
            });
        
            // Inicializa el checkout
            mp.checkout({
            preference: {
                id: "{{ $preference->id }}",
            },
            render: {
                container: ".cho-container",
                label: "Pagar",
            },
            });
        </script>

        <script>
            const btnMP = document.querySelector('.mercadopago-button');
            btnMP.style.cssText = 'width:100%;justify-content: center;display: inline-flex;';
            btnMP.textContent = '';
            var img = document.createElement("img");
            img.src = "{{ asset('img/MP_LOGO_v2.png') }}";
            img.style.cssText = 'height: 3rem;';
            btnMP.appendChild(img);
        </script>

    {{-- Paypal Pasarela de pago --}}
        <script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&currency=MXN"></script>
        <script>
            paypal.Buttons({
            createOrder: (data, actions) => {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                        value: "{{ $order->total }}"
                        }
                    }]
                });
            },
            onApprove: (data, actions) => {
                return actions.order.capture().then(function(orderData) {
                    Livewire.emit('payOrder');
                });
            }
            }).render('#paypal-button-container');
        </script>
    @endpush
</div>
