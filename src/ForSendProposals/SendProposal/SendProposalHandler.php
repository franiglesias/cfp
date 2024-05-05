<?php

declare (strict_types=1);

namespace App\ForSendProposals\SendProposal;


class SendProposalHandler
{
    public function __invoke(SendProposal $command): SendProposalResponse
    {
        throw new \RuntimeException('Implement __invoke() method.');
    }
}
