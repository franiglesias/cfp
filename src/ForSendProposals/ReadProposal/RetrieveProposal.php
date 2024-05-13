<?php

declare (strict_types=1);

namespace App\ForSendProposals\ReadProposal;


interface RetrieveProposal
{
    public function __invoke(string $id): Proposal;
}
