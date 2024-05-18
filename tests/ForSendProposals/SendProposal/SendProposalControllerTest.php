<?php

declare (strict_types=1);

namespace App\Tests\ForSendProposals\SendProposal;

use App\ForSendProposals\SendProposal\ProposalBuilder;
use App\ForSendProposals\SendProposal\SendProposalController;
use App\ForSendProposals\SendProposal\SendProposalHandler;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertStringContainsString;

final class SendProposalControllerTest extends TestCase
{
    private const string PROPOSAL_TITLE = 'Proposal Title';
    private const string PROPOSAL_ID = 'proposal-id';
    private const string NOW = '2024-05-16 12:34:56';

    private SendProposalController $controller;

    protected function setUp(): void
    {
        $identityProvider = new IdentityProviderStub(self::PROPOSAL_ID);
        $clock = new ClockStub(new \DateTimeImmutable(self::NOW));

        $proposalBuilder = new ProposalBuilder($identityProvider, $clock);
        $storeProposal = new StoreProposalFake();

        $handler = new SendProposalHandler($storeProposal, $proposalBuilder);
        $this->controller = new SendProposalController($handler);
    }


    /** @test */
    public function should_accept_well_formed_proposal(): void
    {
        $request = Request::create(
            '/api/proposals',
            'POST',
            [],
            [],
            [],
            ['CONTENT-TYPE' => 'json/application'],
            json_encode(PayloadExample::wellFormedWithTitle(self::PROPOSAL_TITLE))
        );

        $response = ($this->controller)($request);

        assertEquals(202, $response->getStatusCode());
        assertEquals('https://localhost/api/proposals/proposal-id',
            $response->headers->get("Location"));

        $content = json_decode($response->getContent(), true);
        assertStringContainsString(
            'Your proposal titled "Proposal Title" was registered.',
            $content['message']
        );
    }
}
