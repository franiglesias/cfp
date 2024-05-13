<?php

declare (strict_types=1);

namespace App\Tests\ForSendProposals\ReadProposal;

use App\ForSendProposals\ReadProposal\Proposal;
use App\ForSendProposals\ReadProposal\ReadProposal;
use App\ForSendProposals\ReadProposal\ReadProposalHandler;
use App\ForSendProposals\ReadProposal\RetrieveProposal;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

final class ReadProposalHandlerTest extends TestCase
{
    /** @test */
    public function should_retrieve_proposal_with_id(): void
    {
        $proposalId = '01HXE2R5JBCRKAA3K0BZ1TCXT2';
        $now = new \DateTimeImmutable();

        $proposal = new Proposal(
            $proposalId,
            'Proposal Title',
            'A description or abstract of the proposal',
            'Fran Iglesias',
            'fran.iglesias@example.com',
            'talk',
            true,
            'Vigo, Galicia',
            'waiting',
            $now,
        );

        $retrieveProposal = $this->createMock(RetrieveProposal::class);
        $retrieveProposal->method('__invoke')->willReturn($proposal);

        $handler = new ReadProposalHandler($retrieveProposal);
        $command = new ReadProposal($proposalId);

        $response = ($handler)($command);

        assertEquals($proposalId, $response->id);
        assertEquals('Proposal Title', $response->title);
        assertEquals('A description or abstract of the proposal',
            $response->description);
        assertEquals('Fran Iglesias', $response->author);
        assertEquals('fran.iglesias@example.com', $response->email);
        assertEquals('talk', $response->type);
        assertEquals(true, $response->sponsored);
        assertEquals('Vigo, Galicia', $response->location);
        assertEquals('waiting', $response->status);
        assertEquals($now, $response->receivedAt);
    }
}
