<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class MergeTheCartLogout
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        // Eliminar el carrito previo si es que existe
        Cart::erase(auth()->user()->id);

        // Almacena carrito temporalmente si se cierra sesion
        Cart::store(auth()->user()->id);
    }
}
