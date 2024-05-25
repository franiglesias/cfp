<?php

declare (strict_types=1);

namespace App\Tests\ForSendProposals\ReadProposal\Examples;

use App\ForSendProposals\ReadProposal\ProposalNotAvailable;
use App\ForSendProposals\ReadProposal\ProposalNotFound;
use App\ForSendProposals\ReadProposal\ReadProposal;
use App\ForSendProposals\ReadProposal\ReadProposalHandler;
use App\ForSendProposals\ReadProposal\ReadProposalResponse;
use RuntimeException;

class ReadProposalHandlerMother
{
    public static function dummy(): ReadProposalHandler
    {
        return new class() extends ReadProposalHandler {
            public function __construct()
            {
            }

            public function __invoke(ReadProposal $readProposal
            ): ReadProposalResponse {
                throw new RuntimeException('This method should not be called.');
            }
        };
    }

    public static function notAvailable(): ReadProposalHandler
    {
        return new class() extends ReadProposalHandler {
            public function __construct()
            {
            }

            public function __invoke(ReadProposal $readProposal
            ): ReadProposalResponse {
                throw new ProposalNotAvailable('Database failed');
            }
        };
    }

    public static function notFound(): ReadProposalHandler
    {
        return new class() extends ReadProposalHandler {
            public function __construct()
            {
            }

            public function __invoke(ReadProposal $readProposal
            ): ReadProposalResponse {
                throw new ProposalNotFound('No proposal with Id');
            }
        };
    }
}
