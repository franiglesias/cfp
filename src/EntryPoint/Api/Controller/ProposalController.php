<?php

declare (strict_types=1);

namespace App\EntryPoint\Api\Controller;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ProposalController
{
    public function __invoke(Request $request): Response
    {
        $payload = json_decode($request->getContent(), true);
        // map payload to MakeProposalCommand
        // Handle command
        // Handle exceptions if any
        return new JsonResponse([], Response::HTTP_ACCEPTED);
    }

}
