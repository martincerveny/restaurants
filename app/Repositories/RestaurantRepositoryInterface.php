<?php

namespace App\Repositories;

use App\Models\Restaurant;
use Illuminate\Support\Collection;

/**
 * Interface RestaurantRepositoryInterface
 * @package App\Repositories
 */
interface RestaurantRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAllByFilter(): Collection;
}
