<?php

declare (strict_types=1);

namespace App\Tests\ForSendProposals\SendProposal;

use App\ForSendProposals\SendProposal\SendProposal;

class SendProposalExample
{
    public static function wellFormedWithTitle($title): SendProposal
    {
        return new SendProposal(
            $title,
            'A description or abstract of the proposal',
            'Fran Iglesias',
            'fran.iglesias@example.com',
            'talk',
            true,
            'Vigo, Galicia',
        );
    }
}
