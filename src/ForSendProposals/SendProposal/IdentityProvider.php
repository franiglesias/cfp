<?php

declare (strict_types=1);

namespace App\ForSendProposals\SendProposal;


interface IdentityProvider
{
    public function next(): string;
}
