<?php

namespace App\Services;

use Omnipay\Omnipay;

class GatewayFactory
{
    public static function create(string $gatewayName): \Omnipay\Common\AbstractGateway
    {   
        $apiKeys = [

            'Stripe' => env('STRIPE_API_KEY'),
            
        ];
        
        if (!in_array($gatewayName, self::getAvailableGateways())) {
            throw new \InvalidArgumentException("Gateway '$gatewayName' não suportado.");
        }

        if (empty($apiKeys[$gatewayName])) {
            throw new \InvalidArgumentException("Chave de API para o gateway '$gatewayName' não encontrada.");
        }

        $gateway = Omnipay::create($gatewayName);
        $gateway->initialize(['apiKey' => $apiKeys[$gatewayName]]);
        
        return $gateway;
    }

    public static function getAvailableGateways(): array
    {
        
        return ['Stripe'];
        
    }
}
