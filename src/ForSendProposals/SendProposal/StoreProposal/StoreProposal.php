<?php

declare (strict_types=1);

namespace App\ForSendProposals\SendProposal\StoreProposal;


use App\ForSendProposals\SendProposal\Proposal;

interface StoreProposal
{
    public function __invoke(Proposal $proposal);
}
