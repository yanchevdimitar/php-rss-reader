<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feed extends Model
{
    use HasFactory;

    public $timestamps = false;
    /**
     * @var string
     */
    public $table = 'feeds';

    /**
     * @var string[]
     */
    public $fillable = [
        "title",
        "source",
        "source_url",
        "link",
        "publish_date",
        "description"
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [

    ];

    public static array $rules = [

    ];

    /**
     * @return BelongsTo
     */
    public function rss(): BelongsTo
    {
        return $this->belongsTo(Rss::class, 'rss_id');
    }
}
