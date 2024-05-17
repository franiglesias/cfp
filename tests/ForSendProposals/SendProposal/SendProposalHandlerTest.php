<?php

declare (strict_types=1);

namespace App\Tests\ForSendProposals\SendProposal;

use App\ForSendProposals\SendProposal\ProposalBuilder;
use App\ForSendProposals\SendProposal\SendProposalHandler;
use App\ForSendProposals\SendProposal\SendProposalResponse;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

final class SendProposalHandlerTest extends TestCase
{
    private const string PROPOSAL_ID = '01HXE2R5JBCRKAA3K0BZ1TCXT2';
    private const string NOW = '2024-05-16 12:34:56';
    private const string PROPOSAL_TITLE = 'Proposal Title';
    private StoreProposalFake $storeProposal;
    private SendProposalHandler $handler;

    protected function setUp(): void
    {
        $this->storeProposal = new StoreProposalFake();
        $proposalBuilder = new ProposalBuilder(
            new IdentityProviderStub(self::PROPOSAL_ID),
            new ClockStub(new DateTimeImmutable(self::NOW))
        );
        $this->handler = new SendProposalHandler(
            $this->storeProposal,
            $proposalBuilder
        );
    }

    /** @test */
    public function should_store_valid_proposal(): void
    {
        $command = SendProposalExample::wellFormedWithTitle(self::PROPOSAL_TITLE);
        $response = ($this->handler)($command);

        $this->assertSendProposalResponse($response);
        $this->assertCorrectProposalStored();
    }

    private function assertSendProposalResponse(SendProposalResponse $response
    ): void {
        self::assertTrue($response->success);
        assertEquals(self::PROPOSAL_TITLE, $response->title);
        assertEquals(self::PROPOSAL_ID, $response->id);
    }

    private function assertCorrectProposalStored(): void
    {
        $proposal = $this->storeProposal->proposal();
        assertEquals(self::PROPOSAL_TITLE, $proposal->getTitle());
        assertEquals(self::PROPOSAL_ID, $proposal->getId());
        assertEquals(new DateTimeImmutable(self::NOW), $proposal->getReceivedAt());
    }
}
