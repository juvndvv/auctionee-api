<?php

namespace App\Social\Domain\Models;

use App\Social\Domain\Models\ValueObjects\FriendshipUuid;
use App\UserManagement\Domain\Models\ValueObjects\UserId;

class Friendship
{
    private FriendshipUuid $uuid;
    private UserId $left;
    private UserId $right;
}
