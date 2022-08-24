<?php

namespace App\Packages\PaymentDriver;

use GuzzleHttp\Client;
use Shetabit\Multipay\Abstracts\Driver;
use Shetabit\Multipay\Contracts\ReceiptInterface;
use Shetabit\Multipay\Drivers\Vandar\Vandar as BaseVandar;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Exceptions\PurchaseFailedException;
use Shetabit\Multipay\Invoice;
use Shetabit\Multipay\Receipt;
use Shetabit\Multipay\RedirectionForm;
use Shetabit\Multipay\Request;

class Vandar extends BaseVandar
{
    /**
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Shetabit\Multipay\Exceptions\PurchaseFailedException
     */
    public function purchase()
    {
        $data = [
            'api_key' => $this->settings->merchantId,
            'amount' => $this->invoice->getAmount(),
            'callback_url' => $this->settings->callbackUrl,
            'mobile' => $this->invoice->getDetail('mobile'),
            'description' => $this->invoice->getDetail('description'),
        ];

        $response = $this->client
            ->request(
                'POST',
                $this->settings->apiPurchaseUrl,
                [
                    'json' => $data,
                    'headers' => [
                        "Accept" => "application/json",
                    ],
                    'http_errors' => false,
                ]
            );

        $responseBody = json_decode($response->getBody()->getContents(), true);
        $statusCode = (int) $responseBody['status'];

        if ($statusCode !== 1) {
            $errors = array_pop($responseBody['errors']);

            throw new PurchaseFailedException($errors);
        }

        $this->invoice->transactionId($responseBody['token']);

        return $this->invoice->getTransactionId();
    }

    /**
     * @return ReceiptInterface
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Shetabit\Multipay\Exceptions\InvalidPaymentException
     */
    public function verify(): ReceiptInterface
    {
        $token = Request::get('token');
        $paymentStatus = Request::get('payment_status');
        $data = [
            'api_key' => $this->settings->merchantId,
            'token' => $token
        ];

        if ($paymentStatus == self::PAYMENT_STATUS_FAILED) {
            $this->notVerified('پرداخت با شکست مواجه شد.');
        }

        $response = $this->client
            ->request(
                'POST',
                $this->settings->apiVerificationUrl,
                [
                    'json' => $data,
                    'headers' => [
                        "Accept" => "application/json",
                    ],
                    'http_errors' => false,
                ]
            );

        $responseBody = json_decode($response->getBody()->getContents(), true);
        $statusCode = (int) $responseBody['status'];

        if ($statusCode !== 1) {
            if (isset($responseBody['error'])) {
                $message = is_array($responseBody['error']) ? array_pop($responseBody['error']) : $responseBody['error'];
            }

            if (isset($responseBody['errors']) and is_array($responseBody['errors'])) {
                $message = array_pop($responseBody['errors']);
            }

            $this->notVerified($message ?? '');
        }

        return $this->createReceipt($responseBody);
    }

    /**
     * Generate the payment's receipt
     *
     * @param $invoiceDetails
     *
     * @return Receipt
     */
    protected function createReceipt($invoiceDetails)
    {
        $receipt = new Receipt('vandar', $invoiceDetails['transId']);

        foreach ($invoiceDetails as $key => $value)
            $receipt->detail($key, $value);

        return $receipt;
    }
}
