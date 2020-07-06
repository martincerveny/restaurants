<?php


namespace App\Repositories;


use App\Models\Restaurant;
use Illuminate\Support\Collection;

/**
 * Class RestaurantRepository
 * @package App\Repositories
 */
class RestaurantRepository implements RestaurantRepositoryInterface
{
    /**
     * @var Restaurant
     */
    protected $restaurant;

    /**
     * RestaurantRepository constructor.
     * @param Restaurant $restaurant
     */
    public function __construct(Restaurant $restaurant)
    {
        $this->restaurant = $restaurant;
    }

    /**
     * @return Collection
     */
    public function getAllByFilter(): Collection
    {
        $filteredRestaurants = $this->restaurant->where(function ($query) {
            $this->getQueryBySearchFilter($query);
        });
        $filteredRestaurants = $this->getQueryByOpeningHoursFilter($filteredRestaurants);

        return $filteredRestaurants->get();
    }

    /**
     * @param $query
     * @return mixed
     */
    private function getQueryByOpeningHoursFilter($query)
    {
        if (!request()->has('search')) {
            $query->select('restaurants.*')
                ->join('opening_hours as oh', function ($join) {
                    $join->on('oh.restaurant_id', '=', 'restaurants.id');
                    $join->where('oh.day', '=', now()->format('N'));
                    $join->where('open_time', '<=', now()->format('H:i:s'));
                    $join->whereRaw('(IF(oh.open_time > oh.close_time,
                     CONCAT(CURDATE() + INTERVAL 1 DAY, " ", close_time) >= NOW(),
                      close_time >= NOW()))'
                    );
                });
        }

        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    private function getQueryBySearchFilter($query)
    {
        if (request()->has('search')) {
            return $query
                ->whereRaw(' LOWER(`restaurants`.`name`) LIKE ? ',
                    ['%' . trim(strtolower(request()->input('search'))) . '%']);
        }

        return $query;
    }
}
