<?php

declare (strict_types=1);

namespace App\Tests\ForSendProposals\SendProposal;

use App\ForSendProposals\SendProposal\SendProposal;
use App\ForSendProposals\SendProposal\SendProposalController;
use App\ForSendProposals\SendProposal\SendProposalHandler;
use App\ForSendProposals\SendProposal\SendProposalResponse;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertStringContainsString;

final class SendProposalControllerTest extends TestCase
{
    /** @test */
    public function should_accept_well_formed_proposal(): void
    {
        $payload = PayloadExample::wellFormedWithTitle('Proposal Title');

        $request = Request::create(
            '/api/proposals',
            'POST',
            [],
            [],
            [],
            ['CONTENT-TYPE' => 'json/application'],
            json_encode($payload)
        );
        $handler = $this->createMock(SendProposalHandler::class);

        $command = new SendProposal(
            'Proposal Title',
            'A description or abstract of the proposal',
            'Fran Iglesias',
            'fran.iglesias@example.com',
            'talk',
            true,
            'Vigo, Galicia',
        );

        $expected = new SendProposalResponse(
            true,
            'proposal-id',
            'Proposal Title'
        );

        $handler
            ->method('__invoke')
            ->with($command)
            ->willReturn($expected);

        $controller = new SendProposalController($handler);
        $response = ($controller)($request);

        assertEquals(202, $response->getStatusCode());
        assertEquals('https://localhost/api/proposals/proposal-id', $response->headers->get("Location"));

        $content = json_decode($response->getContent(), true);
        assertStringContainsString(
            'Your proposal titled "Proposal Title" was registered.',
            $content['message']
        );
    }
}
