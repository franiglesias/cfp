<?php

declare (strict_types=1);

namespace App\Tests\ForSendProposals\SendProposal;

use App\ForSendProposals\SendProposal\Clock\Clock;
use App\ForSendProposals\SendProposal\IdentityProvider\IdentityProvider;
use App\ForSendProposals\SendProposal\ProposalBuilder;
use App\ForSendProposals\SendProposal\SendProposalHandler;
use App\ForSendProposals\SendProposal\StoreProposal\StoreProposal;
use DateTimeImmutable;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

final class SendProposalHandlerTest extends TestCase
{
    /** @test */
    public function should_store_valid_proposal(): void
    {
        $storeProposal = $this->buildStoreProposal();

        $proposalId = '01HXE2R5JBCRKAA3K0BZ1TCXT2';
        $identityProvider = $this->buildIdentityProvider($proposalId);

        $now = new DateTimeImmutable();
        $clock = $this->buildClock($now);

        $proposalBuilder = new ProposalBuilder(
            $identityProvider,
            $clock
        );

        $handler = new SendProposalHandler(
            $storeProposal,
            $proposalBuilder
        );

        $proposalTitle = 'Proposal Title';
        $command = SendProposalExample::wellFormedWithTitle($proposalTitle);

        $response = ($handler)($command);

        self::assertTrue($response->success);

        assertEquals($proposalTitle, $response->title);
        assertEquals($proposalId, $response->id);
    }

    private function buildStoreProposal(): MockObject|StoreProposal
    {
        $storeProposal = $this->createMock(StoreProposal::class);
        $storeProposal->expects(self::once())->method('__invoke');
        return $storeProposal;
    }

    private function buildIdentityProvider(string $proposalId
    ): MockObject|IdentityProvider {
        $identityProvider = $this->createMock(IdentityProvider::class);
        $identityProvider->method('next')->willReturn($proposalId);
        return $identityProvider;
    }

    private function buildClock(DateTimeImmutable $now): MockObject|Clock
    {
        $clock = $this->createMock(Clock::class);
        $clock->method('now')->willReturn($now);
        return $clock;
    }
}
