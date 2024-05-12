<?php

declare (strict_types=1);

namespace App\ForSendProposals\ReadProposal;


final class ReadProposal
{

    public function __construct(readonly public string $id)
    {
    }
}
