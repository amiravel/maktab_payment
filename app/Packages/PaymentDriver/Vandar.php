<?php

namespace App\Packages\PaymentDriver;

use GuzzleHttp\Client;
use Shetabit\Multipay\{Contracts\ReceiptInterface,
    Exceptions\InvalidPaymentException,
    Exceptions\PurchaseFailedException,
    Invoice,
    Receipt,
    Request
};
use Shetabit\Multipay\Abstracts\Driver;
use Shetabit\Multipay\RedirectionForm;

class Vandar extends Driver
{
    protected $client;
    protected $invoice;
    protected $settings;

    public function __construct(Invoice $invoice, $settings)
    {
        $this->invoice($invoice);
        $this->settings = (object)$settings;
        $this->client = new Client();
    }

    public function purchase()
    {
        $invoiceData = $this->getPreparedInvoiceData();

        $response = $this->client
            ->request(
                'POST',
                $this->settings->apiPurchaseUrl,
                [
                    'json' => $invoiceData,
                    "headers" => [
                        "Accept" => 'application/json',
                        "Content-Type" => 'application/json',
                    ],
                    "http_errors" => false,
                ]
            );

        $result = json_decode($response->getBody()->getContents(), true);

        if (!empty($result['errors']) || $result['status'] == 0) {
            throw new PurchaseFailedException("خطا در ورودی اطلاعات", $result['status']);
        }

        $this->invoice->transactionId($result['token']);

        return $this->invoice->getTransactionId();
    }

    public function pay(): RedirectionForm
    {
        $transactionId = $this->invoice->getTransactionId();
        $paymentUrl = $this->settings->apiPaymentUrl;

        $payUrl = $paymentUrl . $transactionId;

        return $this->redirectWithForm($payUrl, [], 'GET');
    }

    public function verify(): ReceiptInterface
    {
        $status = Request::input('payment_status');

        if ($status != 'OK') {
            throw new InvalidPaymentException('عملیات پرداخت توسط کاربر لغو شد.', -1);
        }

        $token = $this->invoice->getTransactionId() ?? Request::input('token');
        $date = [
            'api_key' => $this->settings->VANDAR_API_TOKEN,
            'token' => $token,
        ];

        $response = $this->client
            ->request(
                'POST',
                $this->settings->apiVerificationUrl,
                [
                    'json' => $date,
                    "headers" => [
                        "Accept" => 'application/json',
                        "Content-Type" => 'application/json',
                    ],
                    "http_errors" => false,
                ]
            );

        $result = json_decode($response->getBody()->getContents(), true);

        if ($result['status'] == 0) {
            $message = implode(' | ', $result['errors']);
            $code = $result['status'];
            throw new InvalidPaymentException($message, $code);
        }

        return $this->createReceipt($result);
    }

    private function getPreparedInvoiceData()
    {
        if (empty($this->preparedData)) {
            $this->preparedData = $this->prepareInvoiceData();
        }

        return $this->preparedData;
    }

    private function prepareInvoiceData()
    {
        $api_key = $this->settings->VANDAR_API_TOKEN;
        $amount = $this->invoice->getAmount();
        $callback_url = $this->settings->callbackUrl;
        $mobile_number = $this->invoice->getDetails()['mobile'];
        $factorNumber = crc32($this->invoice->getUuid()) . rand(0, time());
        $description = $this->invoice->getDetails()['description'];

        return compact('api_key', 'amount', 'callback_url', 'mobile_number', 'factorNumber', 'description');
    }

    private function createReceipt($invoiceDetails)
    {
        $reciept = new Receipt('vandar', $invoiceDetails['transId']);

        foreach ($invoiceDetails as $key => $value)
            $reciept->detail($key, $value);

        return $reciept;
    }
}
