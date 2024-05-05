<?php

declare (strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use function PHPUnit\Framework\assertEquals;

class ProposalsFeatureContext implements Context
{
    private ResponseInterface $response;
    private string $payload;

    /**
     * @Given /^Fran has a proposal with the following content:$/
     */
    public function franHasAProposalWithTheFollowingContent(PyStringNode $payload): void
    {
        $this->payload = $payload->getRaw();
    }

    /**
     * @When /^He sends the proposal$/
     */
    public function heSendsTheProposal(): void
    {
        $client = new Client(
            [
                'base_uri' => 'https://localhost',
            ]
        );
        $this->response = $client->request(
            'POST',
            '/api/proposals',
            [
                'body' => $this->payload,
                'headers' => [
                    'Content-Type' => 'application/json'
                ]
            ]
        );
    }

    /**
     * @Then /^The proposal is acknowledged$/
     */
    public function theProposalIsAcknowledged(): void
    {
        assertEquals(202, $this->response->getStatusCode());
    }

    /**
     * @Then /^The proposal appears in the list of sent proposals$/
     */
    public function theProposalAppearsInTheListOfSentProposals()
    {
        throw new \Behat\Behat\Tester\Exception\PendingException();
    }
}
