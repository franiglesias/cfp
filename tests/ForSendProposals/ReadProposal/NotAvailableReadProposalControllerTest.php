<?php

declare (strict_types=1);

namespace App\Tests\ForSendProposals\ReadProposal;

use App\ForSendProposals\ReadProposal\ProposalNotAvailable;
use App\ForSendProposals\ReadProposal\ProposalNotFound;
use App\ForSendProposals\ReadProposal\ReadProposal;
use App\ForSendProposals\ReadProposal\ReadProposalController;
use App\ForSendProposals\ReadProposal\ReadProposalHandler;
use App\ForSendProposals\ReadProposal\ReadProposalResponse;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use function PHPUnit\Framework\assertEquals;

final class NotAvailableReadProposalControllerTest extends TestCase
{
    public const string PROPOSAL_ID = '01HXMBMMXAG7S1ZFZH98HS3CHP';

    /** @test */
    public function should_fail_with_server_error(): void
    {
        $handler = $this->buildNotAvailableHandler();
        $controller = new ReadProposalController($handler);

        $request = $this->buildRequest('/api/proposals/' . self::PROPOSAL_ID);
        $response = ($controller)(self::PROPOSAL_ID, $request);

        assertEquals(500, $response->getStatusCode());
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
                    'Database failed',
                ]
            ]
        );
    }

    private function buildNotAvailableHandler(): ReadProposalHandler
    {
        return new class() extends ReadProposalHandler {
            public function __construct()
            {
            }

            public function __invoke(ReadProposal $readProposal
            ): ReadProposalResponse {
                throw new ProposalNotAvailable('Database failed');
            }
        };
    }
}
