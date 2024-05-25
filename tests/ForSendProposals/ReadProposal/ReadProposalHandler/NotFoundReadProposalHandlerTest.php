<?php

declare (strict_types=1);

namespace App\Tests\ForSendProposals\ReadProposal\ReadProposalHandler;

use App\ForSendProposals\ReadProposal\Proposal;
use App\ForSendProposals\ReadProposal\ProposalNotFound;
use App\ForSendProposals\ReadProposal\ReadProposal;
use App\ForSendProposals\ReadProposal\ReadProposalHandler;
use App\ForSendProposals\ReadProposal\RetrieveProposal\DataNotFound;
use App\ForSendProposals\ReadProposal\RetrieveProposal\RetrieveProposal;
use PHPUnit\Framework\TestCase;

final class NotFoundReadProposalHandlerTest extends TestCase implements RetrieveProposal
{
    private const string PROPOSAL_ID = '01HXE2R5JBCRKAA3K0BZ1TCXT2';

    /** @test */
    public function should_retrieve_proposal_with_id(): void
    {
        $handler = new ReadProposalHandler($this);
        $command = new ReadProposal(self::PROPOSAL_ID);

        $this->expectException(ProposalNotFound::class);

        ($handler)($command);
    }

    public function __invoke(string $id): Proposal
    {
        throw new DataNotFound(
            'some exception'
        );
    }
}
