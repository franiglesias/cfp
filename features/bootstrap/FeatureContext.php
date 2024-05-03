<?php

use Behat\Behat\Context\Context;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use function PHPUnit\Framework\assertEquals;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private ResponseInterface $response;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @When /^I visit "([^"]*)"$/
     */
    public function iVisit(string $endpoint): void
    {
        $client = new Client();
        $this->response = $client->get('https://localhost' . $endpoint);
    }

    /**
     * @Then /^I obtain a (\d+) status$/
     */
    public function iObtainAStatus(int $statusCode): void
    {
        assertEquals($statusCode, $this->response->getStatusCode());
    }
}
