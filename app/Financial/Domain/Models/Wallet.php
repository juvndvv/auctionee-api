<?php

namespace App\Financial\Domain\Models;

use App\Financial\Domain\Events\TransactionPlaced;
use App\Financial\Domain\Exeptions\NotEnoughFoundsException;
use App\Financial\Domain\Models\ValueObjects\WalletAmount;
use App\Financial\Domain\Models\ValueObjects\WalletUuid;
use App\Shared\Domain\Models\AggregateRoot;
use App\User\Domain\Models\ValueObjects\UserId;
use Illuminate\Support\Collection;

class Wallet extends AggregateRoot
{
    public const SERIALIZED_UUID = 'uuid';
    public const SERIALIZED_AMOUNT = 'amount';
    public const SERIALIZED_USER_UUID = 'user_uuid';
    public const SERIALIZED_TRANSACTIONS = 'transactions';

    private readonly WalletUuid $uuid;
    private WalletAmount $amount;
    private readonly UserId $userId;
    private Collection $transactions;

    /**
     * @param string $uuid
     * @param float $amount
     * @param string $userId
     * @param Collection<array> $transactions
     */
    public function __construct(
        string $uuid,
        float $amount,
        string $userId,
        Collection $transactions = new Collection()
    )
    {
        $this->uuid = new WalletUuid($uuid);
        $this->amount = new WalletAmount($amount);
        $this->userId = new UserId($userId);
        $this->transactions = $transactions;
    }

    /**
     * Creates a wallet from primitives array
     *
     * @param array $data
     * @return self
     */
    public static function fromPrimitives(array $data): self
    {
        return new self(
            $data[self::SERIALIZED_UUID],
            $data[self::SERIALIZED_AMOUNT],
            $data[self::SERIALIZED_USER_UUID],
        );
    }

    /**
     * @return array
     */
    public function toPrimitives(): array
    {
        $transactionPrimitives = Transaction::mapPrimitivesFromCollection($this->transactions());

        return [
            self::SERIALIZED_UUID => $this->uuid->value(),
            self::SERIALIZED_AMOUNT => $this->amount->value(),
            self::SERIALIZED_USER_UUID => $this->userId->value(),
            self::SERIALIZED_TRANSACTIONS => $transactionPrimitives
        ];
    }

    public function uuid(): string
    {
        return $this->uuid->value();
    }

    public function amount(): float
    {
        return $this->amount->value();
    }

    public function transactions(): Collection
    {
        return $this->transactions;
    }

    public function userId(): string
    {
        return $this->userId->value();
    }

    /**
     * @param Collection<Transaction> $transactions
     * @return void
     */
    public function setTransactions(Collection $transactions): void
    {
        $this->transactions = $transactions;
    }

    /**
     * Creates a wallet
     *
     * @param float $amount
     * @param string $userUuid
     * @param Collection $transactions
     * @return self
     */
    public static function create(float $amount, string $userUuid, Collection $transactions = new Collection()): self
    {
        $uuid = WalletUuid::random();

        return new self(
            $uuid,
            $amount,
            $userUuid,
            $transactions
        );
    }

    /**
     * Add a transaction and create the event
     *
     * @param string $destinationWalletUuid
     * @param float $amount
     * @return void
     * @throws NotEnoughFoundsException
     */
    public function makeTransaction(string $destinationWalletUuid, float $amount): void
    {
        if (!$this->hasEnoughMoney($amount)) {
            throw new NotEnoughFoundsException("No existe suficiente dinero");
        }

        $transaction = Transaction::create($destinationWalletUuid, $amount);
        $this->transactions->add($transaction);

        $this->record(new TransactionPlaced($transaction->toPrimitives($this->uuid()), now()->toString()));
    }

    /**
     * Checks if the wallet has enough money. Used before transfer
     *
     * @param float $amount
     * @return bool
     */
    public function hasEnoughMoney(float $amount): bool
    {
        return $amount <= $this->amount->value();
    }

    /**
     * @param float $amount
     * @return void
     * @throws NotEnoughFoundsException
     */
    public function withdraw(float $amount): void
    {
        if (!$this->hasEnoughMoney($amount)) {
            throw new NotEnoughFoundsException("No existe suficiente dinero");
        }

        $this->amount = new WalletAmount($this->amount->value() - $amount);
    }

    /**
     * @param float $amount
     * @return void
     */
    public function deposit(float $amount): void
    {
        $this->amount = new WalletAmount($this->amount->value() + $amount);
    }
}
