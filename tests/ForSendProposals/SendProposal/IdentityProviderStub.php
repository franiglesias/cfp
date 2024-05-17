<?php

declare (strict_types=1);

namespace App\Tests\ForSendProposals\SendProposal;

use App\ForSendProposals\SendProposal\IdentityProvider\IdentityProvider;

readonly class IdentityProviderStub implements IdentityProvider
{
    public function __construct(private string $id)
    {
    }

    public function next(): string
    {
        return $this->id;
    }
}
