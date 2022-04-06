<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Support\Facades\Request;
use Laminas\Soap\Client;
use SoapServer;

class OrderController extends Controller
{
    protected SoapServer $server;

    public function __construct()
    {
        $this->server = new SoapServer(config('soap.wsdl'));
        $this->server->setObject(new OrderService());
    }

    public function store(\Illuminate\Http\Request $request)
    {
        try {
            ob_start();
            $this->server->handle($request->getContent());
            dd($this->server);
            $response = ob_get_contents();
            ob_end_clean();
        } catch (\Throwable $exception) {
            dd($exception);
        }
    }
}
