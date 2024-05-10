<?php

declare (strict_types=1);

namespace App\ForSendProposals\SendProposal;


use App\ForSendProposals\SendProposal\Clock\Clock;
use App\ForSendProposals\SendProposal\IdentityProvider\IdentityProvider;

final class ProposalBuilder
{
    private IdentityProvider $identityProvider;
    private Clock $clock;

    public function __construct(IdentityProvider $identityProvider, Clock $clock)
    {
        $this->identityProvider = $identityProvider;
        $this->clock = $clock;
    }

    public function fromCommandData(SendProposal $command): Proposal {
        $proposal = new Proposal();
        $proposal->setId($this->identityProvider->next());
        $proposal->setTitle($command->title);
        $proposal->setDescription($command->description);
        $proposal->setAuthor($command->author);
        $proposal->setEmail($command->email);
        $proposal->setType($command->type);
        $proposal->setSponsored($command->sponsored);
        $proposal->setLocation($command->location);
        $proposal->setStatus('waiting');
        $proposal->setReceivedAt($this->clock->now());

        return $proposal;
    }
}
