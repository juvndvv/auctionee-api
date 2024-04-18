<?php

namespace App\Shared\Domain\Bus\Command;


use Illuminate\Support\Facades\App;
use ReflectionClass;
use ReflectionException;

class CommandBus
{
    /**
     * @throws ReflectionException
     */
    public function handle($command)
    {
        // Resolve Handler
        $reflection = new ReflectionClass($command);
        $handlerName = str_replace("Command", "CommandHandler", $reflection->getShortName());
        $handlerName = str_replace($reflection->getShortName(), $handlerName, $reflection->getName());
        $handler = App::make($handlerName);

        // Invoke handler
        return $handler($command);
    }
}
