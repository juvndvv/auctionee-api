<?php

namespace App\Shared\Domain\Bus\Events;

class EventBus
{
    public function dispatch(): void
    {
        foreach(func_get_args() as $event) {
            event($event);
        }
    }
}
