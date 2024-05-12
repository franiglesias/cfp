<?php

declare (strict_types=1);

namespace App\Tests\ForSendProposals\ReadProposal;

use App\ForSendProposals\ReadProposal\ReadProposal;
use App\ForSendProposals\ReadProposal\ReadProposalController;
use App\ForSendProposals\ReadProposal\ReadProposalHandler;
use App\ForSendProposals\ReadProposal\ReadProposalResponse;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use function PHPUnit\Framework\assertEquals;

final class ReadProposalControllerTest extends TestCase
{
    /** @test */
    public function should_retrieve_proposal_by_id(): void
    {
        $id = '01HXMBMMXAG7S1ZFZH98HS3CHP';
        $receivedAt = new \DateTimeImmutable();

        $request = Request::create(
            '/api/proposals/'.$id,
            'GET',
            [],
            [],
            [],
            ['CONTENT-TYPE' => 'json/application'],
        );

        $handler = $this->createMock(ReadProposalHandler::class);

        $query = new ReadProposal($id);

        $expected = new ReadProposalResponse(
            $id,
            'Proposal Title',
            'A description or abstract of the proposal',
            'Fran Iglesias',
            'fran.iglesias@example.com',
            'talk',
            true,
            'Vigo, Galicia',
            'waiting',
            $receivedAt,
        );

        $handler
            ->method('__invoke')
            ->with($query)
            ->willReturn($expected);

        $controller = new ReadProposalController($handler);
        $response = ($controller)($id, $request);

        $body = json_encode(
            [
                'id' => $id,
                'title' => 'Proposal Title',
                'description' => 'A description or abstract of the proposal',
                'author' => 'Fran Iglesias',
                'email' => 'fran.iglesias@example.com',
                'type' => 'talk',
                'sponsored' => true,
                'location' => 'Vigo, Galicia',
                'status' => 'waiting',
                'receivedAt' => $receivedAt,
            ]
        );

        assertEquals(200, $response->getStatusCode());
        assertEquals($body, $response->getContent());
    }
}
