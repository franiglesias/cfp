<?php

declare (strict_types=1);

namespace App\ForSendProposals\ReadProposal;


use DateTimeImmutable;

final readonly class Proposal
{

    public function __construct(
        public string $id,
        public string $title,
        public string $description,
        public string $author,
        public string $email,
        public string $type,
        public true $sponsored,
        public string $location,
        public string $status,
        public DateTimeImmutable $receivedAt
    )
    {
    }
}
