<?php

namespace Abdullah\IsyerimPos\Services;

use Abdullah\IsyerimPos\Client\IsyerimPosClient;

class PhysicalPosService
{
    public function __construct(
        protected IsyerimPosClient $client
    ) {}

    /**
     * Get list of POS terminals.
     */
    public function getTerminals(): array
    {
        return $this->client->post('terminals');
    }

    /**
     * Create a cart for POS device.
     *
     * @param  array{
     *     Name?: string,
     *     TerminalId?: string,
     *     Direct?: bool,
     *     PaymentType?: int,
     *     CashAmount?: float,
     *     Items: array<array{
     *         Count: int,
     *         Name: string,
     *         TaxValue: float,
     *         UnitPrice: float
     *     }>,
     *     BuyerInfo?: array{
     *         IdentityNR: string,
     *         Name: string,
     *         Surname: string,
     *         PhoneNumber?: string,
     *         EMail?: string,
     *         Title?: string,
     *         TaxOffice: string,
     *         AddressInfo: array{
     *             City: string,
     *             District: string,
     *             StreetName?: string,
     *             BuildingNumber?: string,
     *             DoorNumber?: string
     *         }
     *     }
     * }  $data
     */
    public function createCart(array $data): array
    {
        return $this->client->post('createCart', $data);
    }

    /**
     * Get list of carts.
     *
     * @param  string|null  $tid  Terminal ID (optional)
     */
    public function getCarts(?string $tid = null): array
    {
        $endpoint = 'getCarts';

        if ($tid) {
            $endpoint .= "?tid={$tid}";
        }

        return $this->client->post($endpoint);
    }

    /**
     * Delete a cart.
     *
     * @param  string  $cartId  Cart identifier
     */
    public function deleteCart(string $cartId): array
    {
        return $this->client->post('deleteCart', [
            'cartId' => $cartId,
        ]);
    }
}
