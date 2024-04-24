<?php

namespace App\Financial\Domain\Models;

use App\Financial\Domain\Models\ValueObjects\TransactionAmount;
use App\Financial\Domain\Models\ValueObjects\TransactionUuid;
use App\Financial\Domain\Models\ValueObjects\WalletUuid;
use Illuminate\Support\Collection;

class Transaction
{
    private TransactionUuid $uuid;
    private WalletUuid $destinationWalletUuid;
    private TransactionAmount $amount;

    /**
     * @param string $uuid
     * @param string $destinationWalletUuid
     * @param float $amount
     */
    public function __construct(string $uuid, string $destinationWalletUuid, float $amount)
    {
        $this->uuid = new TransactionUuid($uuid);
        $this->destinationWalletUuid = new WalletUuid($destinationWalletUuid);
        $this->amount = new TransactionAmount($amount);
    }

    /**
     * @param array $data
     * @return self
     */
    public static function fromPrimitives(array $data): self
    {
        return new self(
            $data['uuid'],
            $data['destination_wallet_uuid'],
            $data['amount']
        );
    }

    /**
     * @return array
     */
    public function toPrimitives(): array
    {
        return [
            $this->uuid(),
            $this->destinationWalletUuid(),
            $this->amount(),
        ];
    }

    /**
     * @return string
     */
    public function uuid(): string
    {
        return $this->uuid->value();
    }

    /**
     * @return string
     */
    public function destinationWalletUuid(): string
    {
        return $this->destinationWalletUuid->value();
    }

    /**
     * @return float
     */
    public function amount(): float
    {
        return $this->amount->value();
    }

    /**
     * @param string $destinationWalletUuid
     * @param float $amount
     * @return self
     */
    public static function create(string $destinationWalletUuid, float $amount): self
    {
        $uuid = TransactionUuid::random();
        return new self(
            $uuid->value(),
            $destinationWalletUuid,
            $amount
        );
    }

    /**
     * @param array $data
     * @return Collection<self>
     */
    public static function getCollectionFromPrimitivesArray(array $data): Collection
    {
        return collect(
            array_map(
                function (array $transaction) {
                    return self::fromPrimitives($transaction);
                }, $data
            )
        );
    }

    /**
     * @param Collection<self> $collection
     * @return array
     */
    public static function getPrimitivesFromCollection(Collection $collection): array
    {
        return array_map(
            function (array $transaction) {
                return $transaction->toPrimitives();
            }, $collection->toArray());
    }
}
