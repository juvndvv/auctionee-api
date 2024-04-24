<?php

namespace App\Social\Domain\Models;

use App\UserManagement\Domain\Models\ValueObjects\UserId;
use Illuminate\Support\Collection;

class Chat
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
        return $this->messages;
    }
}
