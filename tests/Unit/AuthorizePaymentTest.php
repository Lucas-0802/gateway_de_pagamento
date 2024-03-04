<?php

namespace Tests\Unit;

use App\Http\Requests\AuthorizeRequest;
use Tests\TestCase;
use App\Services\PaymentService;

class AuthorizeRequestTest extends TestCase
{   
    public function testShouldReturnIdIfSucceedInApi()
    {
        $mockGateway = new class {

            public function authorize() {
                return $this;
            }
            public function send() {
                return new class {
                    public function isSuccessful() {
                        return true;
                    }
                    public function getData() {
                        return ['id' => 'idResult'];
                    }
                };
            }
    
        };

        $paymentService = new PaymentService($mockGateway);

        $request = new AuthorizeRequest();

        $response = $paymentService->authorizePayment($request);
        
        $this->assertEquals($response, [
            'id' => 'idResult'
        ]);
        
    }

    public function testShouldReturnIdIfFailInApi() {

        $mockGateway = new class {

            public function authorize() {
                return $this;
            }
            public function send() {
                return new class {
                    public function isSuccessful() {
                        return false;
                    }
                    public function getMessage() {
                        return 'Erro na API';
                    }
                };
            }
    
        };

        $paymentService = new PaymentService($mockGateway);

        $request = new AuthorizeRequest();
        
        $error = null;

        try {
            
            $paymentService->authorizePayment($request);
            
        } catch (\Throwable $th) {
           $error = $th->getMessage();
        }
        
        $this->assertEquals('Erro na API', $error);
    }
}
