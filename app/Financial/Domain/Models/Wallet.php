<?php

namespace App\Financial\Domain\Models;

use App\Financial\Domain\Models\ValueObjects\WalletAmount;
use App\Financial\Domain\Models\ValueObjects\WalletUuid;
use App\Shared\Domain\Models\AggregateRoot;
use App\UserManagement\Domain\Models\ValueObjects\UserId;
use Ramsey\Collection\Collection;

class Wallet extends AggregateRoot
{
    private readonly WalletUuid $uuid;
    private readonly WalletAmount $amount;
    private readonly UserId $userId;
    private readonly Collection $transactions;

    public function __construct(
        string $uuid,
        float $amount,
        string $userId
    )
    {
        $this->uuid = new WalletUuid($uuid);
        $this->amount = new WalletAmount($amount);
        $this->userId = new UserId($userId);
    }

    public static function fromPrimitives(array $data): self
    {
        return new self(
            $data['uuid'],
            $data['amount'],
            $data['user_uuid']
        );
    }

    public function toPrimitives(): array
    {
        return [
            'uuid' => $this->uuid->value(),
            'amount' => $this->amount->value(),
            'userUuid' => $this->userId->value(),
            // TODO return transactions
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

    public function userId()
    {
        return $this->userId->value();
    }
}
