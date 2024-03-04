<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\PaymentController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('payment')->group(function () {

    Route::post('/authorize', [PaymentController::class, 'authorizePayment']);
    Route::post('/{id}/capture', [PaymentController::class, 'capturePayment']);
    Route::post('/{id}/refund', [PaymentController::class, 'refundPayment']);
    Route::delete('/{id}/void', [PaymentController::class, 'voidPayment']);
    
 });


