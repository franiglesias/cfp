<?php

declare (strict_types=1);

namespace App\Tests\ForSendProposals\SendProposal;

class PayloadExample
{
    public static function wellFormedWithTitle(string $title): array
    {
        return [
            'title' => $title,
            'description' => 'A description or abstract of the proposal',
            'author' => 'Fran Iglesias',
            'email' => 'fran.iglesias@example.com',
            'type' => 'talk',
            'sponsored' => true,
            'location' => 'Vigo, Galicia',
        ];
    }
}
