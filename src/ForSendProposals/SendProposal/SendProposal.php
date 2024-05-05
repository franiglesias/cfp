<?php

declare (strict_types=1);

namespace App\ForSendProposals\SendProposal;


final readonly class SendProposal
{
    public function __construct(
        public string $title,
        public string $description,
        public string $name,
        public string $email,
        public string $type,
        public bool   $sponsored,
        public string $location
    )
    {
    }
}
