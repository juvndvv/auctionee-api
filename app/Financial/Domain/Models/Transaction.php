<?php

namespace App\Financial\Domain\Models;

use App\Financial\Domain\Models\ValueObjects\TransactionAmount;
use App\Financial\Domain\Models\ValueObjects\TransactionUuid;
use App\Financial\Domain\Models\ValueObjects\WalletUuid;
use Illuminate\Support\Collection;

final class Transaction
{
    public const string SERIALIZED_UUID = 'uuid';
    public const string SERIALIZED_REMITTENT_WALLET_UUID = 'remittent_wallet_uuid';
    public const string SERIALIZED_DESTINATION_WALLET_UUID = 'destination_wallet_uuid';
    public const string SERIALIZED_AMOUNT = 'amount';

    private TransactionUuid $uuid;
    private WalletUuid $remittentWalletUuid;
    private WalletUuid $destinationWalletUuid;
    private TransactionAmount $amount;
    private string $createdAt;

    /**
     * @param string $uuid
     * @param string $remittentWalletUuid
     * @param string $destinationWalletUuid
     * @param float $amount
     */
    public function __construct(
        string $uuid,
        string $remittentWalletUuid,
        string $destinationWalletUuid,
        float $amount,
        string $createdAt)
    {
        $this->uuid = new TransactionUuid($uuid);
        $this->remittentWalletUuid = new WalletUuid($remittentWalletUuid);
        $this->destinationWalletUuid = new WalletUuid($destinationWalletUuid);
        $this->amount = new TransactionAmount($amount);
        $this->createdAt = $createdAt;
    }

    /**
     * @param array $data
     * @return self
     */
    public static function fromPrimitives(array $data): self
    {
        return new self(
            $data[self::SERIALIZED_UUID],
            $data[self::SERIALIZED_REMITTENT_WALLET_UUID],
            $data[self::SERIALIZED_DESTINATION_WALLET_UUID],
            $data[self::SERIALIZED_AMOUNT],
            $data['created_at']
        );
    }

    /**
     * @return array
     */
    public function toPrimitives(): array
    {
        return [
            self::SERIALIZED_UUID => $this->uuid(),
            self::SERIALIZED_REMITTENT_WALLET_UUID => $this->remittentWalletUuid(),
            self::SERIALIZED_DESTINATION_WALLET_UUID => $this->destinationWalletUuid(),
            self::SERIALIZED_AMOUNT => $this->amount(),
            'createdAt' => $this->createdAt
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
    public function remittentWalletUuid(): string
    {
        return $this->remittentWalletUuid->value();
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

    public function createdAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $remittentUuid
     * @return void
     */
    public function updateRemittent(string $remittentUuid): void
    {
        $this->remittentWalletUuid = new WalletUuid($remittentUuid);
    }

    /**
     * @param string $destinationUuid
     * @return void
     */
    public function updateDestination(string $destinationUuid): void
    {
        $this->destinationWalletUuid = new WalletUuid($destinationUuid);
    }

    /**
     * @param string $remittentWalletUuid
     * @param string $destinationWalletUuid
     * @param float $amount
     * @return self
     */
    public static function create(string $remittentWalletUuid, string $destinationWalletUuid, float $amount, string $createdAt): self
    {
        $uuid = TransactionUuid::random();

        return new self(
            $uuid->value(),
            $remittentWalletUuid,
            $destinationWalletUuid,
            $amount,
            $createdAt
        );
    }

    /**
     * Maps from array of primitives transactions to Collection<Transaction>
     *
     * @param array $data
     * @return Collection
     */
    public static function mapCollectionFromPrimitivesArray(array $data): Collection
    {
        return collect(
            array_map(
                function (array $transactionPrimitive): Transaction {
                    return Transaction::fromPrimitives($transactionPrimitive);
                }, $data)
        );
    }

    /**
     * Maps from Collection<Transaction> to array of primitives transactions
     *
     * @param Collection<Transaction> $collection
     * @return array
     */
    public static function mapPrimitivesFromCollection(Collection $collection): array
    {
        return $collection
            ->map(
                function (Transaction $transaction): array {
                    return $transaction->toPrimitives();})
            ->toArray();
    }
}
