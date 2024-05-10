<?php

declare (strict_types=1);

namespace App\ForSendProposals\SendProposal;


use App\ForSendProposals\SendProposal\StoreProposal\StoreProposal;

class SendProposalHandler
{
    private StoreProposal $storeProposal;
    private ProposalBuilder $builder;

    public function __construct(
        StoreProposal $storeProposal,
        ProposalBuilder $builder
    )
    {
        $this->storeProposal = $storeProposal;
        $this->builder = $builder;
    }

    public function __invoke(SendProposal $command): SendProposalResponse
    {
        $proposal = $this->builder->fromCommandData($command);

        try {
            ($this->storeProposal)($proposal);
            return new SendProposalResponse(true, $proposal->getId(),
                $proposal->getTitle());
        } catch (\Exception $e) {
            return new SendProposalResponse(false, $proposal->getId(),
                $e->getMessage());
        }
    }
}
