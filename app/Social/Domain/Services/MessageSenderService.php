<?php

namespace App\Social\Domain\Services;

use App\Social\Domain\Models\Message;
use App\Social\Domain\Ports\ChatMessagesRepository;

class MessageSenderService
{
    public function __construct()
    {}

    public function sendMessage(Message $message): void
    {}
}
