<?php

namespace App\Social\Domain\Ports;

use App\Social\Domain\Models\Message;

interface ChatMessagesRepositoryPort
{
    public function save(Message $message): void;
}
