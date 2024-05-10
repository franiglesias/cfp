<?php

declare (strict_types=1);

namespace App\ForSendProposals\SendProposal;


interface StoreProposal
{
    public function __invoke(Proposal $proposal);
}
