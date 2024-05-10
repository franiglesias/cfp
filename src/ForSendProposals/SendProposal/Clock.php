<?php

declare (strict_types=1);

namespace App\ForSendProposals\SendProposal;


use DateTimeImmutable;

interface Clock
{
    public function now(): DateTimeImmutable;
}
