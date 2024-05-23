<?php

declare (strict_types=1);

namespace App\ForSendProposals\ReadProposal;


interface RetrieveProposal
{
    /**
     * @throws ReadingProposalException
     */
    public function __invoke(string $id): Proposal;
}
