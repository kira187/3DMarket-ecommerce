<?php

namespace App\Console;

use App\Models\Order;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function() {
            $hora = now()->subMinute(10);

            $orders = Order::where('status', Order::PENDIENTE)->whereTime('created_at', '<=', $hora)->get();
            
            foreach ($orders as $order) {
                $items = json_decode($order->content);

                foreach ($items as $item) {
                    recovery_stock($item);
                }
                
                $order->status = Order::ANULADO;
                $order->save();
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
