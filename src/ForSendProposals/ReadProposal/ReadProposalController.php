<?php

declare (strict_types=1);

namespace App\ForSendProposals\ReadProposal;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Ulid\Exception\InvalidUlidStringException;
use Ulid\Ulid;

final class ReadProposalController
{
    private ReadProposalHandler $handler;

    public function __construct(ReadProposalHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(string $id, Request $request): Response
    {
        try {
            $this->validateId($id);
            $query = new ReadProposal($id);
            $response = ($this->handler)($query);
        } catch (InvalidUlidStringException $e) {
            return $this->failureResponse(
                sprintf('Invalid Id: %s', $id),
                Response::HTTP_BAD_REQUEST
            );
        } catch (ProposalNotFound $e) {
            return $this->failureResponse(
                $e->getMessage(),
                Response::HTTP_NOT_FOUND
            );
        } catch (ProposalNotAvailable $e) {
            return $this->failureResponse(
                $e->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return new JsonResponse($response, Response::HTTP_OK);
    }

    private function failureResponse(string $message, int $status): JsonResponse
    {
        $response = [
            'errors' => [
                $message
            ],
        ];
        return new JsonResponse($response, $status);
    }

    private function validateId(string $id): void
    {
        Ulid::fromString($id);
    }
}
