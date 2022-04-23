<?php

namespace App\Events;

use App\Models\Rss;
use Illuminate\Queue\SerializesModels;

class RssSaved
{
    use SerializesModels;

    public Rss $rss;

    /**
     * Create a new event instance.
     *
     * @param
     */
    public function __construct(Rss $rss)
    {
        $this->rss = $rss;
    }
}
