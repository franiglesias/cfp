<?php

declare (strict_types=1);

namespace App\ForSendProposals\ReadProposal;


class ReadProposalHandler
{
    private RetrieveProposal $retrieveProposal;

    public function __construct(RetrieveProposal $retrieveProposal)
    {
        $this->retrieveProposal = $retrieveProposal;
    }


    public function __invoke(ReadProposal $readProposal): ReadProposalResponse
    {
        $proposal = ($this->retrieveProposal)($readProposal->id);

        return new ReadProposalResponse(
            $proposal->id,
            $proposal->title,
            $proposal->description,
            $proposal->author,
            $proposal->email,
            $proposal->type,
            $proposal->sponsored,
            $proposal->location,
            $proposal->status,
            $proposal->receivedAt,
        );
    }
}
