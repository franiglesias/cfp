<?php

declare (strict_types=1);

namespace App\Tests\ForSendProposals\ReadProposal;

use App\ForSendProposals\ReadProposal\Proposal;
use App\ForSendProposals\ReadProposal\ReadProposal;
use App\ForSendProposals\ReadProposal\ReadProposalHandler;
use App\ForSendProposals\ReadProposal\ReadProposalResponse;
use App\ForSendProposals\ReadProposal\RetrieveProposal\RetrieveProposal;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

final class ReadProposalHandlerTest extends TestCase implements RetrieveProposal
{
    private const string PROPOSAL_ID = '01HXE2R5JBCRKAA3K0BZ1TCXT2';
    private const string NOW = '2024-05-15 21:05';

    /** @test */
    public function should_retrieve_proposal_with_id(): void
    {
        $handler = new ReadProposalHandler($this);
        $command = new ReadProposal(self::PROPOSAL_ID);

        $response = ($handler)($command);

        $this->assertIsTheExpectedProposal($response);
    }

    public function __invoke(string $id): Proposal
    {
        return new Proposal(
            self::PROPOSAL_ID,
            'Proposal Title',
            'A description or abstract of the proposal',
            'Fran Iglesias',
            'fran.iglesias@example.com',
            'talk',
            true,
            'Vigo, Galicia',
            'waiting',
            new \DateTimeImmutable(self::NOW),
        );
    }

    public function assertIsTheExpectedProposal(ReadProposalResponse $response): void {
        assertEquals(self::PROPOSAL_ID, $response->id);
        assertEquals('Proposal Title', $response->title);
        assertEquals('A description or abstract of the proposal', $response->description);
        assertEquals('Fran Iglesias', $response->author);
        assertEquals('fran.iglesias@example.com', $response->email);
        assertEquals('talk', $response->type);
        assertEquals(true, $response->sponsored);
        assertEquals('Vigo, Galicia', $response->location);
        assertEquals('waiting', $response->status);
        assertEquals(new \DateTimeImmutable(self::NOW), $response->receivedAt);
    }
}
