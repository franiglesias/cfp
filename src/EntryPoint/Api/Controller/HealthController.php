<?php

declare (strict_types=1);

namespace App\EntryPoint\Api\Controller;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class HealthController
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse([], Response::HTTP_OK);
    }

}
