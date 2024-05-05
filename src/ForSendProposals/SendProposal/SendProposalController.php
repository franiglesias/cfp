<?php

declare (strict_types=1);

namespace App\ForSendProposals\SendProposal;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SendProposalController
{
    private SendProposalHandler $handler;

    public function __construct(SendProposalHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Request $request): Response
    {
        $command = $this->buildCommand($request);
        $response = ($this->handler)($command);

        return $this->buildResponse($response);
    }

    private function buildCommand(Request $request): SendProposal
    {
        $payload = json_decode($request->getContent(), true);

        return new SendProposal(
            $payload['title'],
            $payload['description'],
            $payload['author'],
            $payload['email'],
            $payload['type'],
            $payload['sponsored'],
            $payload['location'],
        );
    }

    private function buildResponse(SendProposalResponse $response): JsonResponse
    {
        $message = sprintf('Your proposal titled "%s" was registered.',
            $response->title);
        $jsonResponse = new JsonResponse(['message' => $message],
            Response::HTTP_ACCEPTED);
        $jsonResponse->headers->set("Location",
            "https://localhost/api/proposals/" . $response->id);

        return $jsonResponse;
    }
}
