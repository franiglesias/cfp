<?php

declare (strict_types=1);

namespace App\Tests\Proposal\MakeProposal;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class MakeProposalTest extends WebTestCase
{
    public function testProposalIsSent(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = WebTestCase::createClient();

        // Request a specific page
        $data = [
            "title" => "Proposal title",
            "abstract" => "Proposal description",
            "author" => "Ann Onymous",
            "email" => "ann@example.com",
            "type" => "talk",
            "sponsored" => "yes"
        ];
        $crawler = $client->request(
            'POST',
            '/proposals',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode($data),
        );

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }
}
