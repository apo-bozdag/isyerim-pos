<?php

namespace Abdullah\IsyerimPos\Services;

use Abdullah\IsyerimPos\Client\IsyerimPosClient;

class WalletService
{
    public function __construct(
        protected IsyerimPosClient $client
    ) {}

    /**
     * Get list of wallet accounts.
     */
    public function getWalletAccounts(): array
    {
        return $this->client->post('walletAccounts');
    }

    /**
     * Get wallet balance.
     *
     * @param  int  $walletId  Wallet identifier
     */
    public function getWalletBalance(int $walletId): array
    {
        return $this->client->post("walletBalance?walletId={$walletId}");
    }

    /**
     * Get wallet transaction history.
     *
     * @param  string  $startDate  Start date (Y-m-d format)
     * @param  string  $endDate  End date (Y-m-d format)
     * @param  int  $walletId  Wallet identifier
     */
    public function getWalletTransactions(string $startDate, string $endDate, int $walletId): array
    {
        return $this->client->post("walletTransactions?startDate={$startDate}&endDate={$endDate}&walletId={$walletId}");
    }

    /**
     * Request money transfer/collection.
     *
     * @param  array{
     *     identityNo: string,
     *     amount: float,
     *     url?: string
     * }  $data
     */
    public function collectionRequest(array $data): array
    {
        return $this->client->post('collectionRequest', $data);
    }
}
