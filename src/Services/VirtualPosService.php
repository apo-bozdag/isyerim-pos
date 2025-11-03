<?php

namespace Abdullah\IsyerimPos\Services;

use Abdullah\IsyerimPos\Client\IsyerimPosClient;

class VirtualPosService
{
    public function __construct(
        protected IsyerimPosClient $client
    ) {}

    /**
     * Get installment options for a card.
     *
     * @param  string  $cardNumber  Card number
     * @param  float  $amount  Transaction amount
     * @param  bool  $reflectCost  Whether to reflect cost to customer
     */
    public function getInstallments(string $cardNumber, float $amount, bool $reflectCost = true): array
    {
        return $this->client->post('getInstallments', [
            'CardNumber' => $cardNumber,
            'Amount' => $amount,
            'ReflectCost' => $reflectCost,
        ]);
    }

    /**
     * Initiate a 3D Secure payment request.
     *
     * @param  array{
     *     ReturnUrl: string,
     *     OrderId: string,
     *     ClientIp: string,
     *     Installment: int,
     *     Amount: float,
     *     Is3D: bool,
     *     IsAutoCommit: bool,
     *     CardInfo: array{
     *         CardOwner: string,
     *         CardNo: string,
     *         Month: string,
     *         Year: string,
     *         Cvv: string
     *     },
     *     CustomerInfo: array{
     *         Name: string,
     *         Phone: string,
     *         Email: string,
     *         Address?: string,
     *         Description?: string
     *     },
     *     Products?: array<array{Name: string, Count: int, UnitPrice: float}>,
     *     Payments?: array<array{
     *         CustomerId?: int,
     *         ExtCustomerId?: string,
     *         AccountOwner: string,
     *         IBAN: string,
     *         Description?: string,
     *         Amount: float
     *     }>
     * }  $data
     */
    public function payRequest3d(array $data): array
    {
        return $this->client->post('payRequest3d', $data);
    }

    /**
     * Complete a 3D Secure payment.
     *
     * @param  string  $uid  Unique transaction identifier
     * @param  string  $key  Security key
     */
    public function payComplete(string $uid, string $key): array
    {
        return $this->client->post("payComplete?uid={$uid}&key={$key}");
    }

    /**
     * Check payment result.
     *
     * @param  string  $uid  Unique transaction identifier
     */
    public function payResultCheck(string $uid): array
    {
        return $this->client->post("payResultCheck?uid={$uid}");
    }

    /**
     * Get commission rates.
     */
    public function getCommissions(): array
    {
        return $this->client->post('commissions');
    }

    /**
     * Cancel a transaction.
     *
     * @param  string  $uid  Unique transaction identifier
     * @param  string  $description  Cancellation description
     */
    public function cancelRequest(string $uid, string $description = ''): array
    {
        return $this->client->post('cancelRequest', [
            'uid' => $uid,
            'description' => $description,
        ]);
    }

    /**
     * Refund a transaction.
     *
     * @param  string  $uid  Unique transaction identifier
     * @param  float  $amount  Refund amount (0 for full refund)
     * @param  string  $description  Refund description
     */
    public function refundRequest(string $uid, float $amount = 0, string $description = ''): array
    {
        return $this->client->post('refundRequest', [
            'uid' => $uid,
            'amount' => $amount,
            'description' => $description,
        ]);
    }

    /**
     * Get transaction report.
     *
     * @param  string  $startDate  Start date (Y-m-d format)
     * @param  string  $endDate  End date (Y-m-d format)
     */
    public function getTransactions(string $startDate, string $endDate): array
    {
        return $this->client->post("transactions?startDate={$startDate}&endDate={$endDate}");
    }

    /**
     * Create a payment link.
     *
     * @param  array{
     *     LifeTime: int,
     *     Amount: float,
     *     ReturnUrl: string,
     *     InstallmentActive: bool,
     *     Description?: string,
     *     SendSms?: bool,
     *     SendMail?: bool,
     *     Customer: array{
     *         Name: string,
     *         Surname: string,
     *         Phone: string,
     *         Email?: string,
     *         City?: string,
     *         Address?: string,
     *         Description?: string
     *     },
     *     Products: array<array{Name: string, Count: int, UnitPrice: float}>
     * }  $data
     */
    public function createPayLink(array $data): array
    {
        return $this->client->post('createPayLink', $data);
    }
}
