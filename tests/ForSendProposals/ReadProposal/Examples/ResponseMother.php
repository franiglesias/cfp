<?php

declare (strict_types=1);

namespace App\Tests\ForSendProposals\ReadProposal\Examples;

class ResponseMother
{
    public static function failedWithMessage(string $message): string
    {
        return json_encode(
            [
                'errors' => [
                    $message
                ]
            ]
        );
    }
}
