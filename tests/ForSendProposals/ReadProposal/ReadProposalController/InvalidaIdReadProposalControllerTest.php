<?php

declare (strict_types=1);

namespace App\Tests\ForSendProposals\ReadProposal\ReadProposalController;

use App\ForSendProposals\ReadProposal\ReadProposalController;
use App\Tests\ForSendProposals\ReadProposal\Examples\ReadProposalHandlerMother;
use App\Tests\ForSendProposals\ReadProposal\Examples\RequestMother;
use App\Tests\ForSendProposals\ReadProposal\Examples\ResponseMother;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;
use function sprintf;

final class InvalidaIdReadProposalControllerTest extends TestCase
{
    public const string PROPOSAL_ID = '123456789';

    /** @test */
    public function should_fail_with_bad_request(): void
    {
        $handler = ReadProposalHandlerMother::dummy();
        $controller = new ReadProposalController($handler);

        $request = RequestMother::get('/api/proposals/' . self::PROPOSAL_ID);
        $response = ($controller)(self::PROPOSAL_ID, $request);

        assertEquals(400, $response->getStatusCode());
        assertEquals(ResponseMother::failedWithMessage(sprintf('Invalid Id: %s', self::PROPOSAL_ID)), $response->getContent());
    }
}

