<?php

declare (strict_types=1);

namespace App\ForSendProposals\ReadProposal;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ReadProposalController
{
    private ReadProposalHandler $handler;

    public function __construct(ReadProposalHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(string $id, Request $request): Response
    {
        $query = new ReadProposal($id);
        $response = ($this->handler)($query);

        return new JsonResponse($response, Response::HTTP_OK);
    }
}
