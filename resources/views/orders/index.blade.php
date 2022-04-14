<x-app-layout>
    <div class="container py-12">
        <section class="grid grid-cols-5 gap-6 text-white">
            <a href="{{ route('orders.index') . "?status=1"}}" class="bg-red-500 bg-opacity-75 rounded-lg px-12 py-12 pt-8 pb-4">
                <p class="text-center text-2xl">{{ $ordersPending }}</p>
                <p class="text-center uppercase">Pendiente</p>
                <p class="text-center text-2xl mt-2">
                    <i class="fas fa-business-time"></i>
                </p>
            </a>
            <a href="{{ route('orders.index') . "?status=2"}}" class="bg-gray-500 bg-opacity-75 rounded-lg px-12 py-12 pt-8 pb-4">
                <p class="text-center text-2xl">{{ $ordersRecived }}</p>
                <p class="text-center uppercase">Recibido</p>
                <p class="text-center text-2xl mt-2">
                    <i class="fas fa-credit-card"></i>
                </p>
            </a>
            <a href="{{ route('orders.index') . "?status=3"}}" class="bg-yellow-500 bg-opacity-75 rounded-lg px-12 py-12 pt-8 pb-4">
                <p class="text-center text-2xl">{{ $ordersSended }}</p>
                <p class="text-center uppercase">Enviado</p>
                <p class="text-center text-2xl mt-2">
                    <i class="fas fa-truck"></i>
                </p>
            </a>
            <a href="{{ route('orders.index') . "?status=4"}}" class="bg-pink-500 bg-opacity-75 rounded-lg px-12 py-12 pt-8 pb-4">
                <p class="text-center text-2xl">{{ $ordersDelivered }}</p>
                <p class="text-center uppercase">Entregado</p>
                <p class="text-center text-2xl mt-2">
                    <i class="fas fa-check-circle"></i>
                </p>
            </a>
            <a href="{{ route('orders.index') . "?status=5"}}" class="bg-green-500 bg-opacity-75 rounded-lg px-12 py-12 pt-8 pb-4">
                <p class="text-center text-2xl">{{ $ordersCanceled }}</p>
                <p class="text-center uppercase">Anulado</p>
                <p class="text-center text-2xl mt-2">
                    <i class="fas fa-times-circle"></i>
                </p>
            </a>
        </section>

        <section class="card px-12 py-8 mt-12 text-gray-700">
            <h1 class="text-2xl mb-4">Pedidos recientes</h1>

            <ul>
                @forelse ($orders as $order)
                    <li>
                        <a class="flex items-center py-2 px-4 hover:bg-gray-100 rounded-sm" href="{{ route('orders.show', $order)}}">
                            <span class="w-12 items-center">
                                @switch($order->status)
                                    @case(1)
                                        <i class="fas fa-business-time text-red-500 opacity-50"></i>
                                        @break
                                    @case(2)
                                        <i class="fas fa-credit-card text-gray-500 opacity-50"></i>
                                        @break
                                    @case(2)
                                        <i class="fas fa-truck text-yellow-500 opacity-50"></i>
                                        @break
                                    @case(2)
                                        <i class="fas fa-circle-check text-pink-500 opacity-50"></i>
                                        @break
                                    @case(2)
                                        <i class="fas fa-times-circle text-green-500 opacity-50"></i>
                                        @break
                                    @default
                                        
                                @endswitch
                            </span>
                            <span>
                                Orden: {{ $order->id }}
                                <br>
                                {{ $order->created_at->format('d/m/Y')}}
                            </span>

                            <div class="ml-auto">
                                <span class="font-bold">
                                    {{ $order->description_status }}
                                </span>
                                <span class="text-sm">
                                    $ {{ $order->total }}
                                </span>
                            </div>
                            <span>
                                <i class="fas fa-angle-right ml-6"></i>
                            </span>
                        </a>
                    </li>
                @empty
                    
                @endforelse
            </ul>
        </section>
    </div>
</x-app-layout>