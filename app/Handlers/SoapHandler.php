<?php

namespace App\Handlers;

use App\Contracts\BaseHandler;
use App\Responses\OrderResponse;
use CodeDredd\Soap\Facades\Soap;
use CodeDredd\Soap\SoapClient;
use SoapFault;
use stdClass;

class SoapHandler extends BaseHandler
{
    protected $settings;
    protected $client;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function getBillByReference(string $reference, array $additional = []): InvoiceQueryResponse
    {
        $result = $this->makeCall('getBillByReference', [
            'reference' => $reference,
        ]);

        return $this->parseResponse($result->getBillByReferenceResult ?? null);
    }

    public function getBillByDebtorID(string $document, array $additional = []): InvoiceQueryResponse
    {
        $result = $this->makeCall('getBillByDebtorID', [
            'debtorID' => $document,
        ]);

        return $this->parseResponse($result->getBillByDebtorIDResult ?? null);
    }

    public function getBillByDebtorCode(string $debtorCode, array $additional = []): InvoiceQueryResponse
    {
        $result = $this->makeCall('getBillByDebtorCode', [
            'debtorCode' => $debtorCode,
        ]);

        return $this->parseResponse($result->getBillByDebtorCodeResult ?? null);
    }


    protected function makeCall($method, $data): stdClass
    {
        try {
            return Soap::baseWsdl()->call($method, $data);
        } catch (SoapFault $exception) {
            return (object)[
                $method . 'Result' => (object)[
                    'status' => 'FAILED',
                    'description' => $exception->getMessage(),
                ],
            ];
        }
    }

    protected function parseResponse(stdClass $result = null): InvoiceQueryResponse
    {
        if (!$result) {
            return InvoiceQueryResponse::empty();
        }

        $data = [
            'status' => $result->status,
            'description' => $result->description,
        ];

        if (isset($result->bills)) {
            foreach ($result->bills as $bill) {
                $bill = $bill[0];
                if (isset($bill)) {
                    $data['invoices'][] = new Invoice([
                        'reference' => $bill->reference ?? '',
                        'description' => $bill->description ?? '',
                        'debtor' => $bill->debtorID ?? '',
                        'amount' => $bill->totalAmount ?? '',
                        'debtorCode' => $bill->debtorCode ?? '',
                        'firstName' => $bill->debtorFirstName ?? '',
                        'lastName' => $bill->debtorLastName ?? '',
                    ]);
                }
            }
        }

        return new InvoiceQueryResponse($data);
    }

    public function queryOrder(int $order): OrderResponse
    {
        $result = $this->makeCall('getBillByDebtorID', [
            'debtorID' => $document,
        ]);
    }

    public function storeOrder(array $request = []): OrderResponse
    {
        // TODO: Implement storeOrder() method.
    }
}
