<?php declare(strict_types=1);

namespace App\Social\Domain\Models;

use App\Shared\Domain\Models\AggregateRoot;
use App\Social\Domain\Events\MessageDeletedEvent;
use App\Social\Domain\Events\MessageSentEvent;
use App\Social\Domain\Models\ValueObjects\ChatRoomUuid;
use App\User\Domain\Models\ValueObjects\UserUuid;
use Illuminate\Support\Collection;

final class ChatRoom extends AggregateRoot
{
    public const string SERIALIZED_UUID = 'uuid';
    public const string SERIALIZED_LEFT_UUID = 'left_uuid';
    public const string SERIALIZED_RIGHT_UUID = 'right_uuid';

    private ChatRoomUuid $uuid;
    private UserUuid $left;
    private UserUuid $right;

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
        $this->left = new UserUuid($leftUuid);
        $this->right = new UserUuid($rightUuid);
        $this->messages = new Collection($messages);
    }

    /**
     * @param array $data
     * @return self
     */
    public static function fromPrimitives(array $data): self
    {
        return new self(
            $data[self::SERIALIZED_UUID],
            $data[self::SERIALIZED_LEFT_UUID],
            $data[self::SERIALIZED_RIGHT_UUID],
        );
    }

    /**
     * @return array
     */
    public function toPrimitives(): array
    {
        return [
            self::SERIALIZED_UUID => $this->uuid(),
            self::SERIALIZED_LEFT_UUID => $this->left(),
            self::SERIALIZED_RIGHT_UUID => $this->right()
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
        return $this->uuid->value();
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
     * @return Collection<Message>
     */
    public function messages(): Collection
    {
        return $this->messages;
    }

    /**
     * @param string $leftUuid
     * @param string $rightUuid
     * @return self
     */
    public static function create(string $leftUuid, string $rightUuid): self
    {
        $uuid = ChatRoomUuid::random()->value();
        return new self($uuid, $leftUuid, $rightUuid);
    }

    /**
     * @param string $senderUuid
     * @param string $content
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
        $this->record(new MessageDeletedEvent($destination, $this->toPrimitives(), now()->toString()));
    }

    private function getDestinationUuid(Message $message): string
    {
        if ($this->left() === $message->senderUuid()) {
            return $this->right();
        }

        return $this->left();
    }
}
