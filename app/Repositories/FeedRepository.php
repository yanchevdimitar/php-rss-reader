<?php

namespace App\Repositories;

use App\Models\Feed;

class FeedRepository extends BaseRepository
{
    public function __construct(Feed $model)
    {
        $this->model = $model;
    }

    public function model(): string
    {
        return Feed::class;
    }

}
