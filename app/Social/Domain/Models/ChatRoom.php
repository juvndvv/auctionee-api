<?php

namespace App\Social\Domain\Models;

use App\Shared\Domain\Models\AggregateRoot;
use App\Social\Domain\Events\MessageSendedEvent;
use App\UserManagement\Domain\Models\ValueObjects\UserId;
use Illuminate\Support\Collection;

class ChatRoom extends AggregateRoot
{
    private UserId $left;
    private UserId $right;
    private Collection $messages;

    /**
     * @param string $leftUuid
     * @param string $rightUuid
     * @param array $messages
     */
    public function __construct(string $leftUuid, string $rightUuid, array $messages = [])
    {
        $this->left = new UserId($leftUuid);
        $this->right = new UserId($rightUuid);
        $this->messages = new Collection($messages);
    }

    public function left(): string
    {
        return $this->left();
    }

    public function right(): string
    {
        return $this->right();
    }

    public function messages(): array
    {
        return $this->messages->toArray();
    }

    public function addMessage(Message $message): void
    {
        $this->messages->add($message);
        $this->record(new MessageSendedEvent($message->toPrimitives(), now()->toString()));
    }
}
