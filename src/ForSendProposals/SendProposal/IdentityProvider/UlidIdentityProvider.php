<?php

declare (strict_types=1);

namespace App\ForSendProposals\SendProposal\IdentityProvider;


use Ulid\Ulid;

final class UlidIdentityProvider implements IdentityProvider
{

    public function next(): string
    {
        $ulid = Ulid::generate();

        return (string)$ulid;
    }
}
