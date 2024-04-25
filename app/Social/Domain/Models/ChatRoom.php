<?php

namespace App\Social\Domain\Models;

use App\Shared\Domain\Models\AggregateRoot;
use App\Social\Domain\Events\MessageDeletedEvent;
use App\Social\Domain\Events\MessageSentEvent;
use App\Social\Domain\Models\ValueObjects\ChatRoomUuid;
use App\UserManagement\Domain\Models\ValueObjects\UserId;
use Illuminate\Support\Collection;

class ChatRoom extends AggregateRoot
{
    private ChatRoomUuid $uuid;
    private UserId $left;
    private UserId $right;

    /**
     * @var Collection<Message>
     */
    private Collection $messages;

    /**
     * @param string $uuid
     * @param string $leftUuid
     * @param string $rightUuid
     * @param array $messages
     */
    public function __construct(string $uuid, string $leftUuid, string $rightUuid, array $messages = [])
    {
        $this->uuid = new ChatRoomUuid($uuid);
        $this->left = new UserId($leftUuid);
        $this->right = new UserId($rightUuid);
        $this->messages = new Collection($messages);
    }

    /**
     * @param array $data
     * @return self
     */
    public static function fromPrimitives(array $data): self
    {
        return new self(
            $data['uuid'],
            $data['left_uuid'],
            $data['right_uuid'],
        );
    }

    /**
     * @return array
     */
    public function toPrimitives(): array
    {
        return [
            'uuid' => $this->uuid(),
            'left_uuid' => $this->left(),
            'right_uuid' => $this->right()
        ];
    }

    public function lastMessagePrimitives(): array
    {
        return $this->messages->toArray()[0]->toPrimitives($this->uuid());
    }

    /**
     * @return string
     */
    public function uuid(): string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function left(): string
    {
        return $this->left->value();
    }

    /**
     * @return string
     */
    public function right(): string
    {
        return $this->right->value();
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return $this->messages->toArray();
    }

    /**
     * @param string $leftUuid
     * @param string $rightUuid
     * @return self
     */
    public static function create(string $leftUuid, string $rightUuid)
    {
        $uuid = ChatRoomUuid::random();
        return new self($uuid, $leftUuid, $rightUuid);
    }

    /**
     * @param Message $message
     * @return void
     */
    public function addMessage(string $senderUuid, string $content): void
    {
        $message = Message::create($senderUuid, $content);
        $destination = $this->getDestinationUuid($message);

        $this->messages->add($message);
        $this->record(new MessageSentEvent($destination, $message->toPrimitives($this->uuid()), now()->toString()));
    }

    public function deleteMessage(Message $message): void
    {
        $destination = $this->getDestinationUuid($message);
        $this->record(new MessageDeletedEvent($destination, [], now()->toString()));
    }

    private function getDestinationUuid(Message $message): string
    {
        if ($this->left() === $message->senderUuid()) {
            return $this->right();
        }

        return $this->left();
    }
}
