<?php

declare (strict_types=1);

namespace App\ForSendProposals\SendProposal\Clock;


use DateTimeImmutable;

final class SystemClock implements Clock
{

    public function now(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
