<?php

declare (strict_types=1);

namespace App\ForSendProposals\ReadProposal;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class NotFoundResponse extends JsonResponse
{
    public function __construct(mixed $message)
    {
        $response = [
            'errors' => [
                $message
            ],
        ];
        parent::__construct($response, Response::HTTP_NOT_FOUND);
    }
}
