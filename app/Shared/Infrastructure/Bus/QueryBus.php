<?php

namespace App\Shared\Infrastructure\Bus;

use Illuminate\Support\Facades\App;
use ReflectionClass;
use ReflectionException;

final readonly class QueryBus
{
    /**
     * @throws ReflectionException
     */
    public function handle($query)
    {
        // resolve handler
        $reflection = new ReflectionClass($query);
        $handlerName = str_replace("Query", "QueryHandler", $reflection->getShortName());
        $handlerName = str_replace($reflection->getShortName(), $handlerName, $reflection->getName());
        $handler = App::make($handlerName);
        // invoke handler
        return $handler($query);
    }
}
