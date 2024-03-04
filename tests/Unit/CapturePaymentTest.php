<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Validation\ValidationException;
use App\Services\PaymentService;

class CapturePaymentTest extends TestCase
{   

    public function testShouldThrowValidationError()
    {
        $id = '';

        $paymentService = new PaymentService(new class{});
        $error = null;

        try {
             $paymentService->capturePayment($id);
        } catch (\Throwable $th) {
           $error = $th;
        }
        
        $this->assertInstanceOf(ValidationException::class, $error);
        
    }

    public function testShouldReturnIdIfSucceedInApi()
    {
        $mockGateway = new class {

            public function capture() {
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

        $id = 'idResult';

        $response = $paymentService->capturePayment($id);
        
        $this->assertEquals($response, [
            'id' => 'idResult'
        ]);
        
    }

    public function testShouldReturnIdIfFailInApi() {

        $mockGateway = new class {

            public function capture() {
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

        $id = 'idResult';
        
        $error = null;

        try {
            
            $paymentService->capturePayment($id);
            
        } catch (\Throwable $th) {
           $error = $th->getMessage();
        }
        
        $this->assertEquals('Erro na API', $error);
    }
}
