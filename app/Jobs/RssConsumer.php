<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use NeedleProject\LaravelRabbitMq\ConsumerInterface;

class RssConsumer implements ShouldQueue
{
    const MAX_MEMORY = 1000000;
    const MAX_TIME = 4;
    const MAX_MESSAGES = 1;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function handle()
    {
        $publisher = app()->makeWith(ConsumerInterface::class, ['rssConsumer']);
        $publisher->startConsuming(self::MAX_MESSAGES, self::MAX_TIME, self::MAX_MEMORY);
    }
}
