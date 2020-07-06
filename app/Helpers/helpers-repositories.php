<?php

if (!function_exists('restaurantRepository')) {
    /**
     * @return \App\Repositories\RestaurantRepositoryInterface
     */
    function restaurantRepository(): \App\Repositories\RestaurantRepositoryInterface
    {
        static $repository = null;
        if (null === $repository) {
            $repository = app(\App\Repositories\RestaurantRepositoryInterface::class);
        }
        return $repository;
    }
}
