<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CalculatePaymentRequest;
use App\Processors\PriceCalculationProcessor;

class PaymentController extends Controller
{
    /**
     * Calculate payment.
     *
     * This endpoint returns price in cents for reservation.
     * @response scenario=success {21475}
     * @response status=403 scenario="Forbidden" {"message": "This action is unauthorized."}
     * @response status=401 scenario="unauthorized" {"message": "Unauthenticated."}
     * @authenticated
     * @group Reservation Management
     */
    public function __invoke(
        CalculatePaymentRequest $request,
        PriceCalculationProcessor $processor
    ): int
    {
        return $processor->process($request->get('reservation_id'));
    }
}
