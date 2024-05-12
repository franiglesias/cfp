<?php

declare (strict_types=1);

namespace App\ForSendProposals\ReadProposal;


use DateTimeImmutable;

final class ReadProposalResponse
{

    public function __construct(
        public readonly string $id,
        public readonly string $title,
        public readonly string $description,
        public readonly string $author,
        public readonly string $email,
        public readonly string $type,
        public readonly true $sponsored,
        public readonly string $location,
        public readonly string $status,
        public readonly DateTimeImmutable $receivedAt
    ) {
    }
}
