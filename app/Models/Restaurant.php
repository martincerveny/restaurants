<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Restaurant
 * @package App\Models
 */
class Restaurant extends Model
{
    /**
     * @var string
     */
    protected $table = 'restaurants';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return HasMany
     */
    public function openingHours(): HasMany
    {
        return $this->hasMany(OpeningHours::class, 'restaurant_id', 'id')
            ->orderBy('day', 'asc');
    }
}
