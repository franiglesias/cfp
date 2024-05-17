<?php

declare (strict_types=1);

namespace App\Tests\ForSendProposals\SendProposal;

use App\ForSendProposals\SendProposal\Proposal;
use App\ForSendProposals\SendProposal\StoreProposal\StoreProposal;

class StoreProposalFake implements StoreProposal
{
    private Proposal $proposal;

    public function __invoke(Proposal $proposal): void
    {
        $this->proposal = $proposal;
    }

    public function proposal(): Proposal
    {
        return $this->proposal;
    }
}
