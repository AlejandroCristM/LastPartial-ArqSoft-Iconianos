<?php

namespace App\Handlers;

use App\Contracts\BaseHandler;
use App\Responses\CustomerResponse;
use App\Responses\OrderResponse;
use App\Responses\RestaurantResponse;
use CodeDredd\Soap\Facades\Soap;
use Illuminate\Support\Arr;
use SoapFault;
use stdClass;

class SoapHandler extends BaseHandler
{
    protected string $wsdl;

    public function __construct()
    {
        $this->wsdl = config('soap.wsdl');
    }

    protected function makeCall($method, $data): stdClass
    {
        try {
            return Soap::baseWsdl($this->wsdl)->call($method, $data)->object();
        } catch (SoapFault $exception) {
            return (object)[
                $method . 'Result' => (object)[
                    'status' => 'FAILED',
                    'description' => $exception->getMessage(),
                ],
            ];
        }
    }

    protected function parseResponse(stdClass $result = null): OrderResponse
    {
        if (!$result) {
            return new OrderResponse();
        }

        $restaurant = $result->restaurant;
        $restaurant = new RestaurantResponse($restaurant->name, $restaurant->address, $restaurant->phone);
        $customer = $result->customer;
        $customer = new CustomerResponse($customer->name, $customer->lastname, $customer->address, $customer->phone);

        return new OrderResponse(
            $result->reference,
            $result->description,
            $result->amount,
            $restaurant,
            $customer
        );
    }

    public function queryOrder(int $order): OrderResponse
    {
        $result = $this->makeCall('queryOrder', [
            'order' => $order,
        ]);

        return $this->parseResponse($result->queryOrderResult ?? null);
    }

    public function storeOrder(array $request = []): OrderResponse
    {
        $result = $this->makeCall('queryOrder', [
            'reference' => Arr::get($request, 'reference'),
            'restaurant_id' => Arr::get($request, 'restaurant_id'),
            'customer_id' => Arr::get($request, 'customer_id'),
            'description' => Arr::get($request, 'description'),
            'amount' => Arr::get($request, 'amount'),
        ]);

        return $this->parseResponse($result->storeOrderResult ?? null);
    }
}
