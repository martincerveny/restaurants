<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\View\View;

/**
 * Class RestaurantController
 * @package App\Http\Controllers
 */
class RestaurantController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $restaurants = restaurantRepository()->getAllByFilter();
        return view('restaurants.layout.index', compact('restaurants'));
    }

    /**
     * @param Restaurant $restaurant
     * @return View
     */
    public function show(Restaurant $restaurant): View
    {
        return view('restaurants.layout.show', compact('restaurant'));
    }
}
