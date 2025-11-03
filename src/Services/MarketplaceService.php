<?php

namespace Abdullah\IsyerimPos\Services;

use Abdullah\IsyerimPos\Client\IsyerimPosClient;

class MarketplaceService
{
    public function __construct(
        protected IsyerimPosClient $client
    ) {}

    /**
     * Add or update a sub-merchant.
     *
     * @param  array{
     *     id?: int,
     *     CreateUser?: bool,
     *     externalCustomerId?: string|null,
     *     companyName: string,
     *     shopName: string,
     *     authorizedPerson: string,
     *     tcIdentityNumber: string,
     *     taxNumber: string,
     *     taxOffice: string,
     *     email: string,
     *     gsmNumber: string,
     *     webAddress?: string,
     *     iban: string,
     *     accountOwner: string,
     *     province: string,
     *     provinceCode: int,
     *     transactionLowerLimit?: float|null,
     *     transactionUpperLimit?: float|null,
     *     transactionTotalLimit?: float|null,
     *     valor?: int,
     *     PaymentDay?: int
     * }  $data
     */
    public function addSubMerchant(array $data): array
    {
        return $this->client->post('addSubmerchant', $data);
    }

    /**
     * Get payment status for a transaction.
     *
     * @param  string  $uid  Unique transaction identifier
     */
    public function getPaymentStatus(string $uid): array
    {
        return $this->client->post("paymentStatus?uid={$uid}");
    }

    /**
     * Get list of payments for a specific date.
     *
     * @param  string  $date  Date in Y-m-d format
     */
    public function getPayments(string $date): array
    {
        return $this->client->post("payments?date={$date}");
    }

    /**
     * Create authentication token for a user.
     *
     * @param  int  $userId  Internal user ID
     * @param  string|null  $extUserId  External user ID
     */
    public function createToken(int $userId, ?string $extUserId = null): array
    {
        $endpoint = "createToken?userId={$userId}";

        if ($extUserId !== null) {
            $endpoint .= "&extUserId={$extUserId}";
        }

        return $this->client->post($endpoint);
    }
}
