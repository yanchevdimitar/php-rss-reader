<?php

namespace App\Services;

use App\Models\Rss;
use NeedleProject\LaravelRabbitMq\Processor\AbstractMessageProcessor;
use PhpAmqpLib\Message\AMQPMessage;

class ConsumerProcessor extends AbstractMessageProcessor
{
    /**
     * @param AMQPMessage $message
     * @return bool
     */
    public function processMessage(AMQPMessage $message): bool
    {
        $this->processFeed($message->getBody());
        return true;
    }

    private function processFeed(string $body)
    {
        $feeds = json_decode($body, true);
        foreach ($feeds as $feed) {
            $url = array_keys($feed['Items'])[0];
            $rss = Rss::where('url', $url)->first();

            if (isset($rss->id)) {
                $rss->deleteFeeds();
                foreach ($feed['Items'][$rss->url] as $item) {
                    $rss->feeds()->create($item);
                }
            }
        }
    }
}
