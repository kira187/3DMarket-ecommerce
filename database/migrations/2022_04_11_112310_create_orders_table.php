<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('contact');
            $table->string('phone');
            $table->enum('status',[Order::PENDIENTE, Order::RECIBIDO, Order::ENVIADO, Order::ENTREGADO, Order::ANULADO])->default(Order::PENDIENTE);
            $table->enum('envio_type', [1,2]);
            $table->float('shipping_cost');
            $table->float('total');
            $table->json('content');
            $table->foreignId('department_id')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->foreignId('district_id')->nullable();
            $table->string('address')->nullable();
            $table->string('references')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
