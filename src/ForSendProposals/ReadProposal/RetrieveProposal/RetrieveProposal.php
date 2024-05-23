<?php

declare (strict_types=1);

namespace App\ForSendProposals\ReadProposal\RetrieveProposal;


use App\ForSendProposals\ReadProposal\Proposal;

interface RetrieveProposal
{
    /**
     * @throws ReadingProposalException
     */
    public function __invoke(string $id): Proposal;
}
