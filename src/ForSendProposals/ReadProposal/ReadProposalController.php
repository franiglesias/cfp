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
            return new BadRequestResponse(sprintf('Invalid Id: %s', $id));
        } catch (ProposalNotFound $e) {
            return new NotFoundResponse($e->getMessage());
        } catch (ProposalNotAvailable $e) {
            return new ServerErrorResponse($e->getMessage());
        }

        return new JsonResponse($response, Response::HTTP_OK);
    }

    private function validateId(string $id): void
    {
        Ulid::fromString($id);
    }
}
