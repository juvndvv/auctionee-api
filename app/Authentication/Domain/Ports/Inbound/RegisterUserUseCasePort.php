<?php

namespace App\Authentication\Domain\Ports\Inbound;

use App\Authentication\Infraestructure\Repositories\Models\EloquentUserModel;

interface RegisterUserUseCasePort
{
    public function invoke(array $data): EloquentUserModel;
}
