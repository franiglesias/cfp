<?php

declare (strict_types=1);

namespace App\Tests\ForSendProposals\ReadProposal;

use App\ForSendProposals\ReadProposal\ReadProposal;
use App\ForSendProposals\ReadProposal\ReadProposalController;
use App\ForSendProposals\ReadProposal\ReadProposalHandler;
use App\ForSendProposals\ReadProposal\ReadProposalResponse;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use function PHPUnit\Framework\assertEquals;

final class InvalidaIdReadProposalControllerTest extends TestCase
{
    public const string PROPOSAL_ID = '123456789';

    /** @test */
    public function should_fail_with_bad_request(): void
    {
        $handler = $this->buildDummyHandler();
        $controller = new ReadProposalController($handler);

        $request = $this->buildRequest('/api/proposals/' . self::PROPOSAL_ID);
        $response = ($controller)(self::PROPOSAL_ID, $request);

        assertEquals(400, $response->getStatusCode());
        assertEquals($this->buildExpectedPayload(), $response->getContent());
    }

    private function buildRequest(string $uri): Request
    {
        return Request::create(
            $uri,
            'GET',
            [],
            [],
            [],
            ['CONTENT-TYPE' => 'json/application'],
        );
    }

    private function buildExpectedPayload(): string|false
    {
        return json_encode(
            [
                'errors' => [
                    sprintf('Invalid Id: %s', self::PROPOSAL_ID)
                ]
            ]
        );
    }

    private function buildDummyHandler(): ReadProposalHandler
    {
        return new class() extends ReadProposalHandler {
            public function __construct()
            {
            }

            public function __invoke(ReadProposal $readProposal
            ): ReadProposalResponse {
                throw new RuntimeException('This method should not be called.');
            }
        };
    }
}
