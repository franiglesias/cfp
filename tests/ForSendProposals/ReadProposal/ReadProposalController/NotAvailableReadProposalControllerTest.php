<?php

declare (strict_types=1);

namespace App\Tests\ForSendProposals\ReadProposal\ReadProposalController;

use App\ForSendProposals\ReadProposal\ReadProposalController;
use App\Tests\ForSendProposals\ReadProposal\Examples\ReadProposalHandlerDoublesFactory;
use App\Tests\ForSendProposals\ReadProposal\Examples\RequestExample;
use App\Tests\ForSendProposals\ReadProposal\Examples\ResponseExample;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

final class NotAvailableReadProposalControllerTest extends TestCase
{
    public const string PROPOSAL_ID = '01HXMBMMXAG7S1ZFZH98HS3CHP';

    /** @test */
    public function should_fail_with_server_error(): void
    {
        $handler = ReadProposalHandlerDoublesFactory::notAvailable();
        $controller = new ReadProposalController($handler);

        $request = RequestExample::get('/api/proposals/' . self::PROPOSAL_ID);
        $response = ($controller)(self::PROPOSAL_ID, $request);

        assertEquals(500, $response->getStatusCode());
        assertEquals(ResponseExample::failedWithMessage('Database failed'),
            $response->getContent());
    }
}
