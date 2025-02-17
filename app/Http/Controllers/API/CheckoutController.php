<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\CheckoutService;
use App\Services\ResponseService;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class CheckoutController extends Controller
{
    protected $checkoutService;

    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    /**
     * Handle the checkout process for the current user's cart.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function checkout(Request $request): JsonResponse
    {
        try {
            $order = $this->checkoutService->checkout();

            return ResponseService::success(new OrderResource($order), 'Checkout completed successfully');
        } catch (Exception $e) {
            return ResponseService::error('An error occurred during checkout', 500);
        }
    }
}