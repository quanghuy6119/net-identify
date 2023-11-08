<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Bus\Queueable;

abstract class RabbitMQ implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    function __construct()
    {
        $this->onConnection(env('RABBITMQ_QUEUE_CONNECTION', 'rabbitmq'));
    }
}
