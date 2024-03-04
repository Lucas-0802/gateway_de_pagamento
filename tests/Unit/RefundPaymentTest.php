<?php

namespace Tests\Unit;

use App\Http\Requests\RefundRequest;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use App\Services\PaymentService;

class RefundPaymentTest extends TestCase
{   
    public function getValidRequest() {
        return new RefundRequest(['transactionReference' => 'idResult', 'amount' => '5.00']);
    }
    public function testShouldThrowValidationError()
    {
        $id = '';

        $paymentService = new PaymentService(new class{});
        $error = null;

        $request = new RefundRequest();

        try {
             $paymentService->refundPayment($request, $id);
        } catch (\Throwable $th) {
           $error = $th;
        }
        
        $this->assertInstanceOf(ValidationException::class, $error);
        
    }

    public function testShouldReturnIdIfSucceedInApi()
    {
        $id = 'idTeste'; 

        $mockGateway = new class {

            public function refund() {
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

        $request = $this->getValidRequest();

        $response = $paymentService->refundPayment($request, $id);
        
        $this->assertEquals($response, [
            'id' => 'idResult'
        ]);
        
    }

    public function testShouldReturnIdIfFailInApi() {

        $id = 'idTeste'; 

        $mockGateway = new class {

            public function refund() {
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

        $request = $this->getValidRequest();
        
        $error = null;

        try {
            
            $paymentService->refundPayment($request, $id);
            
        } catch (\Throwable $th) {
           $error = $th->getMessage();
        }
        
        $this->assertEquals('Erro na API', $error);
    }
}
