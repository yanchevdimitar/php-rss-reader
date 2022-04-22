<?php

namespace App\Repositories;

use App\Models\Rss;

class RssRepository extends BaseRepository
{
    public function __construct(Rss $model)
    {
        $this->model = $model;
    }

    public function model(): string
    {
        return Rss::class;
    }
}
