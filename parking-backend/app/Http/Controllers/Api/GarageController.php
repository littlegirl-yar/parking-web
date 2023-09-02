<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GarageIndexResourceCollection;
use App\Http\Resources\GarageShowResource;
use App\Models\Garage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GarageController extends Controller
{
    /**
     * Get garages.
     *
     *
     * @response scenario=success {
    "data": [
    {
    "id": 1,
    "name": "Dr. Theron McKenzie",
    "zipcode": "75441-6220",
    "coordinates": {
    "lng": 26.57,
    "lat": 44.64
    },
    "total_spots": 12,
    "free_spots": 8
    },
    {
    "id": 2,
    "name": "Joannie Hudson IV",
    "zipcode": "52370",
    "coordinates": {
    "lng": 23.67,
    "lat": 44.24
    },
    "total_spots": 24,
    "free_spots": 19
    }
    ]
    }
     * @group Garage management
     */
    public function index(Request $request) : GarageIndexResourceCollection
    {
        return new GarageIndexResourceCollection(
            Garage::withCount([
                'spots as total_spots',
                'spots as free_spots' => function(Builder $query) {
                    $query->whereDoesntHave('reservations', function(Builder $query) {
                        $query->whereRaw("? BETWEEN start AND end", [now()]);
                    });
                }
            ])->get()
        );
    }

    /**
     * Get garage by id.
     *
     * @group Garage management
     */
    public function show(Garage $garage): GarageShowResource
    {
        $garage->load('prices.size', 'spotAttributes');

        return new GarageShowResource($garage);
    }
}
