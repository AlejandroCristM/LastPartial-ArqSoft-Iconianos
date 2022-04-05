<?php

namespace App\Contracts;

use App\Responses\OrderResponse;

abstract class BaseHandler
{
    abstract public function queryOrder(int $order): OrderResponse;
    abstract public function storeOrder(array $request = []): OrderResponse;
}
