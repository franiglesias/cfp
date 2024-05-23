<?php

declare (strict_types=1);

namespace App\Tests\ForSendProposals\ReadProposal;

use App\ForSendProposals\ReadProposal\Proposal;
use App\ForSendProposals\ReadProposal\ReadProposalController;
use App\ForSendProposals\ReadProposal\ReadProposalHandler;
use App\ForSendProposals\ReadProposal\RetrieveProposal\RetrieveProposal;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use function PHPUnit\Framework\assertEquals;

final class ReadProposalControllerTest extends TestCase
{
    public const string PROPOSAL_ID = '01HXMBMMXAG7S1ZFZH98HS3CHP';
    public const string NOW = '2024-05-15 12:34:56';

    /** @test */
    public function should_retrieve_proposal_by_id(): void
    {
        $handler = new ReadProposalHandler($this->buildRetrieveProposalDouble());
        $controller = new ReadProposalController($handler);

        $request = $this->buildRequest('/api/proposals/' . self::PROPOSAL_ID);
        $response = ($controller)(self::PROPOSAL_ID, $request);

        assertEquals(200, $response->getStatusCode());
        assertEquals($this->buildExpectedPayload(), $response->getContent());
    }

    private function buildRetrieveProposalDouble(): RetrieveProposal
    {
        return new class() implements RetrieveProposal {

            public function __invoke(string $id): Proposal
            {
                return new Proposal(
                    ReadProposalControllerTest::PROPOSAL_ID,
                    'Proposal Title',
                    'A description or abstract of the proposal',
                    'Fran Iglesias',
                    'fran.iglesias@example.com',
                    'talk',
                    true,
                    'Vigo, Galicia',
                    'waiting',
                    new \DateTimeImmutable(ReadProposalControllerTest::NOW),
                );
            }
        };
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
                'id' => self::PROPOSAL_ID,
                'title' => 'Proposal Title',
                'description' => 'A description or abstract of the proposal',
                'author' => 'Fran Iglesias',
                'email' => 'fran.iglesias@example.com',
                'type' => 'talk',
                'sponsored' => true,
                'location' => 'Vigo, Galicia',
                'status' => 'waiting',
                'receivedAt' => new \DateTimeImmutable(self::NOW),
            ]
        );
    }
}
