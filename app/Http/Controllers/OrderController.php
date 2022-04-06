<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use SoapServer;

class OrderController extends Controller
{
    protected SoapServer $server;

    public function __construct()
    {
        $this->server = new SoapServer(config('soap.wsdl'));
        $this->server->setClass(OrderService::class);
    }

    public function store()
    {
        $this->server->handle();
    }
}
