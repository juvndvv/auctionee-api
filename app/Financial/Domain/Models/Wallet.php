<?php

namespace App\Financial\Domain\Models;

use App\Financial\Domain\Events\MoneyBlockedEvent;
use App\Financial\Domain\Events\MoneyUnblockedEvent;
use App\Financial\Domain\Events\TransactionPlacedEvent;
use App\Financial\Domain\Exceptions\NotEnoughFoundsException;
use App\Financial\Domain\Models\ValueObjects\WalletBalance;
use App\Financial\Domain\Models\ValueObjects\WalletBlockedBalance;
use App\Financial\Domain\Models\ValueObjects\WalletUuid;
use App\Shared\Domain\Models\AggregateRoot;
use App\User\Domain\Models\ValueObjects\UserUuid;
use Illuminate\Support\Collection;

final class Wallet extends AggregateRoot
{
    public const string UUID = 'uuid';
    public const string BALANCE = 'balance';
    public const string USER_UUID = 'user_uuid';
    public const string TRANSACTIONS = 'transactions';
    public const string BLOCKED_BALANCE = 'blocked_balance';

    private readonly WalletUuid $uuid;
    private WalletBalance $balance;
    private WalletBlockedBalance $blockedBalance;
    private readonly UserUuid $userId;
    private Collection $transactions;

    /**
     * @param string $uuid
     * @param float $balance
     * @param float $blockedBalance
     * @param string $userId
     * @param Collection<array> $transactions
     */
    public function __construct(
        string     $uuid,
        float      $balance,
        float      $blockedBalance,
        string     $userId,
        Collection $transactions = new Collection()
    )
    {
        $this->uuid = new WalletUuid($uuid);
        $this->balance = new WalletBalance($balance);
        $this->blockedBalance = new WalletBlockedBalance($blockedBalance);
        $this->userId = new UserUuid($userId);
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
            $data[self::UUID],
            $data[self::BALANCE],
            $data[self::BLOCKED_BALANCE],
            $data[self::USER_UUID],
        );
    }

    /**
     * Creates a primitives array from wallet
     *
     * @return array
     */
    public function toPrimitives(): array
    {
        $transactionPrimitives = Transaction::mapPrimitivesFromCollection($this->transactions());

        return [
            self::UUID => $this->uuid(),
            self::BALANCE => $this->balance(),
            self::BLOCKED_BALANCE => $this->blockedBalance(),
            self::USER_UUID => $this->userId(),
            self::TRANSACTIONS => $transactionPrimitives
        ];
    }

    public function uuid(): string
    {
        return $this->uuid->value();
    }

    public function balance(): float
    {
        return $this->balance->value();
    }

    public function blockedBalance(): float
    {
        return $this->blockedBalance->value();
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
     * @param float $balance
     * @param float $blockedBalance
     * @param string $userUuid
     * @param Collection $transactions
     * @return self
     */
    public static function create(float $balance, float $blockedBalance, string $userUuid, Collection $transactions = new Collection()): self
    {
        $uuid = $userUuid;

        return new self(
            $uuid,
            $balance,
            $blockedBalance,
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

        $transaction = Transaction::create($this->uuid(), $destinationWalletUuid, $amount);
        $this->transactions->add($transaction);

        $this->record(new TransactionPlacedEvent($transaction->toPrimitives(), now()->toString()));
    }

    /**
     * Checks if the wallet has enough money. Used before transfer
     *
     * @param float $amount
     * @return bool
     */
    public function hasEnoughMoney(float $amount): bool
    {
        return $amount <= $this->balance->value();
    }

    /**
     * Withdraw money in the account
     *
     * @param float $amount
     * @return void
     * @throws NotEnoughFoundsException
     */
    public function withdraw(float $amount): void
    {
        if (!$this->hasEnoughMoney($amount)) {
            throw new NotEnoughFoundsException("No existe suficiente dinero");
        }

        $this->balance = new WalletBalance($this->balance->value() - $amount);
    }

    /**
     * Deposit money in the account
     *
     * @param float $amount
     * @return void
     */
    public function deposit(float $amount): void
    {
        $this->balance = new WalletBalance($this->balance->value() + $amount);
    }

    /**
     * Block balance for the wallet. Generate event
     *
     * @param float $amount
     * @return void
     */
    public function blockBalance(float $amount): void
    {
        $this->balance = new WalletBalance($this->balance->value() - $amount);
        $this->blockedBalance = new WalletBlockedBalance($this->blockedBalance->value() + $amount);
        $this->record(new MoneyBlockedEvent($this->userId(), ['amount' => $amount], now()->toString()));
    }

    /**
     * Unblock balance for the wallet. Generate event
     *
     * @param float $amount
     * @return void
     */
    public function unblockBalance(float $amount): void
    {
        $this->blockedBalance = new WalletBlockedBalance($this->blockedBalance->value() - $amount);
        $this->balance = new WalletBalance($this->balance->value() + $amount);
        $this->record(new MoneyUnblockedEvent($this->userId(), ['amount' => $amount], now()->toString()));
    }
}
