<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Services\GatewayFactory;
use App\Http\Requests\AuthorizeRequest;
use App\Http\Requests\CaptureRequest;
use App\Http\Requests\VoidRequest;
use App\Http\Requests\RefundRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

require_once __DIR__.'/../../vendor/autoload.php' ;


class PaymentService {

    private $gateway;

    function __construct($gateway) {
        $this->gateway = $gateway;
    }

    public function authorizePayment(AuthorizeRequest $request)
    {      
        
            $formData = [
            
                'amount' => $request->amount,
                'currency' => $request->currency,
                'token' => $request->token,
                'card' => $request->card,
                'clientIp' => $request->clientIp,
                'description' => $request->description
            ];

            $response = $this->gateway->authorize($formData)->send();

            if ($response->isSuccessful()) {
                
                return $response->getData(); 

            } 

            throw new \Exception($response->getMessage());
            
    }
    public function capturePayment($id)
    {       
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|string|min:1',
        ]);

        
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
           
            $formData = [
                
                'transactionReference' => $id

            ];

            $response = $this->gateway->capture($formData)->send();

            if ($response->isSuccessful()) {
                
                return $response->getData();

            } 

            throw new \Exception($response->getMessage());
    }
    
    public function refundPayment(RefundRequest $request, $id)
    {   

        $validator = Validator::make(['id' => $id], [
            'id' => 'required|string|min:1',
        ]);

        
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $formData = [
            
            'transactionReference' => $id,
            'amount' => $request->amount

        ];

        $response = $this->gateway->refund($formData)->send();

        if ($response->isSuccessful()) {
            
            return $response->getData();

        } 

        throw new \Exception($response->getMessage());
    }

    public function voidPayment($id)
    {

            $validator = Validator::make(['id' => $id], [
                'id' => 'required|string|min:1',
            ]);

            
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $formData = [
                
                'transactionReference' => $id
    
            ];

            $response = $this->gateway->void($formData)->send();

            if ($response->isSuccessful()) {
                
                return $response->getData();
            } 

            throw new \Exception($response->getMessage());
    }

}