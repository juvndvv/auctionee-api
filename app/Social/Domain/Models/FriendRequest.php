<?php

namespace App\Social\Domain\Models;

use App\Social\Domain\Models\ValueObjects\FriendRequestUuid;
use App\UserManagement\Domain\Models\ValueObjects\UserId;

class FriendRequest
{
    private FriendRequestUuid $uuid;
    private UserId $sender;
    private UserId $reveiver;
}
