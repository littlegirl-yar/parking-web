<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Models\Reservation;
use App\Processors\PriceCalculationProcessor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Checkout.
     *
     * This endpoint returns url of Stripe checkout form.
     * @response scenario=success {"url": "https://checkout.stripe.com/pay/cs_test_a1bdYTCzfUUKKGRdO2vggm2jtpnyZmjuPEsvBsJTyqyJO4MtSkmq2A2Uoz#fidkdWxOYHwnPyd1blpxYHZxWjA0TmNiU2dNbWRKfU5McnFIaTNpM0ZLZGBcREhMT11xMExgdkt3a1Zpa0RqZmBqaUBHaUlQdGBQNUFTfGxqVUBiYmdXVklXXWBWblRiZk5nXGFcSFxoS3Y2NTVXMW9jd0E3aScpJ2N3amhWYHdzYHcnP3F3cGApJ2lkfGpwcVF8dWAnPyd2bGtiaWBabHFgaCcpJ2BrZGdpYFVpZGZgbWppYWB3dic%2FcXdwYHgl"}
     * @response status=403 scenario="Forbidden" {"message": "This action is unauthorized."}
     * @response status=401 scenario="unauthorized" {"message": "Unauthenticated."}
     * @authenticated
     * @group Reservation Management
     */
    public function show(
        CheckoutRequest $request,
        PriceCalculationProcessor $processor,
        Reservation $reservation): JsonResponse
    {
        $url = $request->user()->checkoutCharge(
            $processor->process(
                $reservation->id),
                "Reservation #{$reservation->id} ({$reservation->start->format('d-m-Y H:i')} - {$reservation->end->format('d-m-Y H:i')})",
            1,
            [
                'success_url' => "http://localhost:3000/checkout/{$reservation->uuid}?response=success",
                'cancel_url' => "http://localhost:3000",
                'metadata' => [
                    'reservationId' => $reservation->id,
                    'reservationUUID' => $reservation->uuid
                ]
            ]
        )->asStripeCheckoutSession()->url;

        return response()->json(['url' => $url], 200);
    }
}
