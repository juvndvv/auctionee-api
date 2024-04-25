<?php

namespace App\Social\Domain\Resources;

class FriendResource
{
    private function __construct(
        private readonly string $uuid,
        private readonly string $name,
        private readonly string $avatar,
    )
    {}

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function avatar(): string
    {
        return $this->avatar;
    }

    /**
     * Serializa el objeto
     *
     * @return array
     */
    public function serialize(): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'avatar' => $this->avatar,
        ];
    }

    /**
     * Crea una instancia de la clase
     *
     * @param string $uuid
     * @param string $name
     * @param string $avatar
     * @return self
     */
    public static function create(string $uuid, string $name, string $avatar): self
    {
        return new self($uuid, $name, $avatar);
    }
}
