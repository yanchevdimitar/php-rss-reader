<?php

namespace App\Listeners;

use App\Events\RssSaved as RssSavedEvent;
use App\Repositories\RssRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use NeedleProject\LaravelRabbitMq\PublisherInterface;

class RssChanged
{
    /**
     * @throws BindingResolutionException
     */
    public function handle(RssSavedEvent $event)
    {
        $rssRepository = new RssRepository($event->rss);
        $urls = $rssRepository->get();
        $subset = $urls->map(function ($urls) {
            return collect($urls->toArray())
                ->only(['url'])
                ->all();
        });

        $publisher = app()->makeWith(PublisherInterface::class, ['urlPublisher']);
        $publisher->publish(json_encode($subset, JSON_UNESCAPED_SLASHES), "*");
    }
}
