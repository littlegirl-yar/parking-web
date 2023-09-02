<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationCreateRequest;
use App\Http\Requests\ReservationDestroyRequest;
use App\Http\Requests\ReservationUpdateRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationController extends Controller
{
    /**
     * Get reservation by uuid.
     *
     * @response scenario=success {
    "data": {
    "id": 293,
    "spot_id": "18",
    "start": "2022-04-07 08:30:00",
    "end": "2022-04-08 00:30:00",
    "paid_at": "2022-04-07 06:38:33",
    "paid_amount": 11280,
    "created_at": "2022-04-07 06:37:47"
    }
    }
     * @response status=401 scenario="unauthorized" {"message": "Unauthenticated."}
     * @authenticated
     * @group Reservation Management
     */
    public function show(Request $request, Reservation $reservation): ReservationResource
    {
        return new ReservationResource($reservation);
    }

    /**
     * Make reservation.
     * @response scenario=success {
    "data": {
    "id": 345,
    "spot_id": "14",
    "start": "2022-04-17 00:00:00",
    "end": "2022-04-18 00:00:00",
    "paid_at": null,
    "paid_amount": null,
    "created_at": "2022-04-10 16:49:02"
    }
    }
     * @response status=422 scenario="validation error" {
    "message": "The given data was invalid.",
    "errors": {
    "range": [
    "A reservation for this spot with this period is not valid."
    ]
    }
    }
     * @response status=401 scenario="unauthorized" {"message": "Unauthenticated."}
     * @authenticated
     * @group Reservation Management
     */
    public function store(ReservationCreateRequest $request): ReservationResource
    {
        $reservation = $request->user()->reservations()->create($request->validated());

        return new ReservationResource($reservation);
    }
    /**
     * Update reservation.
     * @response scenario=success {
    "data": {
    "id": 345,
    "spot_id": "14",
    "start": "2022-05-21 00:00:00",
    "end": "2022-05-22 00:00:00",
    "paid_at": null,
    "paid_amount": null,
    "created_at": "2022-04-10 16:49:02"
    }
    }
     * @response status=422 scenario="validation error" {
    "message": "The given data was invalid.",
    "errors": {
    "end": [
    "The end field is required."
    ]
    }
    }
     * @response status=403 scenario="Forbidden" {"message": "This action is unauthorized."}
     * @response status=401 scenario="unauthorized" {"message": "Unauthenticated."}
     * @authenticated
     * @group Reservation Management
     */
    public function update(ReservationUpdateRequest $request, Reservation $reservation): ReservationResource
    {
        $reservation->update($request->validated());

        return new ReservationResource($reservation->fresh());
    }
    /**
     * Delete reservation.
     *
     * @response status=403 scenario="Forbidden" {"message": "This action is unauthorized."}
     * @response success status=204 scenario="no content"
     * @authenticated
     * @group Reservation Management
     */
    public function destroy(ReservationDestroyRequest $request, Reservation $reservation): JsonResponse
    {
        $reservation->delete();

        return response()->json([], 204);
    }
}
