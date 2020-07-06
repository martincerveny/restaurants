<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OpeningHours
 * @package App\Models
 */
class OpeningHours extends Model
{
    /**
     * @var string
     */
    protected $table = 'opening_hours';

    /**
     * @var array
     */
    protected $guarded = ['id'];
}
