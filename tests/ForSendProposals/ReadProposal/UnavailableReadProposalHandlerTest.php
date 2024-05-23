<?php

declare (strict_types=1);

namespace App\Tests\ForSendProposals\ReadProposal;

use App\ForSendProposals\ReadProposal\Proposal;
use App\ForSendProposals\ReadProposal\ProposalNotAvailable;
use App\ForSendProposals\ReadProposal\ReadProposal;
use App\ForSendProposals\ReadProposal\ReadProposalHandler;
use App\ForSendProposals\ReadProposal\RetrieveProposal\ReadingProposalException;
use App\ForSendProposals\ReadProposal\RetrieveProposal\RetrieveProposal;
use PHPUnit\Framework\TestCase;

final class UnavailableReadProposalHandlerTest extends TestCase implements RetrieveProposal
{
    private const string PROPOSAL_ID = '01HXE2R5JBCRKAA3K0BZ1TCXT2';
    private const string NOW = '2024-05-15 21:05';

    /** @test */
    public function should_retrieve_proposal_with_id(): void
    {
        $handler = new ReadProposalHandler($this);
        $command = new ReadProposal(self::PROPOSAL_ID);

        $this->expectException(ProposalNotAvailable::class);

        ($handler)($command);
    }

    public function __invoke(string $id): Proposal
    {
        throw new ReadingProposalException(
            'some exception',
            1,
            new \Exception('some DB exception')
        );
    }
}
