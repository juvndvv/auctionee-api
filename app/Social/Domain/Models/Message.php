<?php

namespace App\Social\Domain\Models;

use App\Social\Domain\Models\ValueObjects\MessageContent;
use App\UserManagement\Domain\Models\ValueObjects\UserId;

class Message
{
    private UserId $sender;
    private MessageContent $content;
}
