<?php

namespace App\Models;

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
     * @return HasMany
     */
    public function freeRegistrations(): HasMany
    {
        return $this->hasMany(Feed::class, 'rss_id');
    }
}
