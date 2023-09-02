<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SpotIndexRequest;
use App\Http\Resources\SpotResourceCollection;
use App\Models\Garage;

class SpotController extends Controller
{
    /**
     * Get spots.
     *
     * This endpoint returns list of spots for a specific garage. The result can also be filtered with additional body parameters.
     * @group Garage management
     */
    public function index(SpotIndexRequest $request, Garage $garage): SpotResourceCollection
    {
        return new SpotResourceCollection(
            $garage
                ->spots()
                ->filter($request->validated())
                ->with('spotAttributes')
                ->with('size')
                ->get()
        );
    }
}
