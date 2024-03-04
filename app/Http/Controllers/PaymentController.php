<?php

namespace App\Http\Controllers;

use App\Services\GatewayFactory;
use App\Http\Requests\AuthorizeRequest;
use App\Http\Requests\CaptureRequest;
use App\Http\Requests\VoidRequest;
use App\Http\Requests\RefundRequest;
use App\Services\PaymentService;

require_once __DIR__.'/../../../vendor/autoload.php' ;

class PaymentController extends Controller {

    public function getGateway($name) {

        if (empty($name)) {
            return response()->json([
                'errors' => "Gateway is required",
            ], 500); 
        }

        $gateway = GatewayFactory::create($name);

        return $gateway;

    }

    public function getService($request) {

        $gateway = $this->getGateway($request->input('gatewayName'));
           
        return new PaymentService($gateway);
    }

    public function authorizePayment(AuthorizeRequest $request)
    {      
        
        try {

            $service = $this->getService($request);

            return $service->authorizePayment($request);

        }  catch (\Exception $e) {
            
            return response()->json([
                'errors' => $e->getMessage(),
            ], 500); 
        }
    }
    public function capturePayment(CaptureRequest $request, $id)
    {   
        try {

            $service = $this->getService($request);

            return $service->capturePayment($id);

        }  catch (\Exception $e) {
            
            return response()->json([
                'errors' => $e->getMessage(),
            ], 500); 
        }
    }
    
    public function refundPayment(RefundRequest $request, $id)
    {   

        try {

            $service = $this->getService($request);

            return $service->refundPayment($request, $id);

        }  catch (\Exception $e) {
            
            return response()->json([
                'errors' => $e->getMessage(),
            ], 500); 
        }
    }

    public function voidPayment(VoidRequest $request, $id)
    {

        try {

            $service = $this->getService($request);

            return $service->voidPayment($id);

        }  catch (\Exception $e) {
            
            return response()->json([
                'errors' => $e->getMessage(),
            ], 500); 
        }
    }

}