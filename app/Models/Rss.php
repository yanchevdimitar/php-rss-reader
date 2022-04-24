<?php

namespace App\Models;

use App\Events\RssDelete;
use App\Events\RssSaved;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rss extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    public $table = 'rsses';

    /**
     * @var string[]
     */
    public $fillable = [
        "url"
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    public static array $rules = [
        'url' => 'required|url',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => RssSaved::class,
        'deleted' => RssDelete::class,
    ];

    /**
     * @return HasMany
     */
    public function feeds(): HasMany
    {
        return $this->hasMany(Feed::class, 'rss_id');
    }

    public function deleteFeeds(): ?bool
    {
        return $this->feeds()->delete();
    }
}
