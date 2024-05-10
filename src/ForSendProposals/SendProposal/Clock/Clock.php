<?php

declare (strict_types=1);

namespace App\ForSendProposals\SendProposal\Clock;


use DateTimeImmutable;

interface Clock
{
    public function now(): DateTimeImmutable;
}
