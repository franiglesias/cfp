<?php

declare (strict_types=1);

namespace App\ForSendProposals\SendProposal;


final readonly class SendProposalResponse
{
    public function __construct(
        public bool   $success,
        public string $id,
        public string $title)
    {
    }
}
