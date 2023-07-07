<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class Authenticate extends Middleware
{
    protected function unauthenticated($request, array $guards)
    {
        throw new BadRequestException('Unauthenticated');
    }
}
