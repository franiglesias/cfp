<?php

declare (strict_types=1);

namespace App\Tests\ForSendProposals\ReadProposal\ReadProposalController;

use App\ForSendProposals\ReadProposal\ReadProposalController;
use App\Tests\ForSendProposals\ReadProposal\Examples\ReadProposalHandlerDoublesFactory;
use App\Tests\ForSendProposals\ReadProposal\Examples\RequestExample;
use App\Tests\ForSendProposals\ReadProposal\Examples\ResponseExample;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;
use function sprintf;

final class InvalidaIdReadProposalControllerTest extends TestCase
{
    public const string PROPOSAL_ID = '123456789';

    /** @test */
    public function should_fail_with_bad_request(): void
    {
        $handler = ReadProposalHandlerDoublesFactory::dummy();
        $controller = new ReadProposalController($handler);

        $request = RequestExample::get('/api/proposals/' . self::PROPOSAL_ID);
        $response = ($controller)(self::PROPOSAL_ID, $request);

        assertEquals(400, $response->getStatusCode());
        assertEquals(ResponseExample::failedWithMessage(sprintf('Invalid Id: %s', self::PROPOSAL_ID)), $response->getContent());
    }
}

