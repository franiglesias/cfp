<?php

declare (strict_types=1);

namespace App\Tests\ForSendProposals\ReadProposal\Examples;

use Symfony\Component\HttpFoundation\Request;

class RequestMother
{
    public static function get(string $uri): Request
    {
        return Request::create(
            $uri,
            'GET',
            [],
            [],
            [],
            ['CONTENT-TYPE' => 'json/application'],
        );
    }
}
