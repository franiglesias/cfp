<?php

declare (strict_types=1);

namespace App\Tests\ForSendProposals\ReadProposal\ReadProposalController;

use App\ForSendProposals\ReadProposal\ReadProposalController;
use App\Tests\ForSendProposals\ReadProposal\Examples\ReadProposalHandlerMother;
use App\Tests\ForSendProposals\ReadProposal\Examples\RequestMother;
use App\Tests\ForSendProposals\ReadProposal\Examples\ResponseMother;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

final class NotFoundReadProposalControllerTest extends TestCase
{
    public const string PROPOSAL_ID = '01HXMBMMXAG7S1ZFZH98HS3CHP';

    /** @test */
    public function should_fail_with_not_found(): void
    {
        $handler = ReadProposalHandlerMother::notFound();
        $controller = new ReadProposalController($handler);

        $request = RequestMother::get('/api/proposals/' . self::PROPOSAL_ID);
        $response = ($controller)(self::PROPOSAL_ID, $request);

        assertEquals(404, $response->getStatusCode());
        assertEquals(ResponseMOther::failedWithMessage('No proposal with Id'),
            $response->getContent());
    }
}
