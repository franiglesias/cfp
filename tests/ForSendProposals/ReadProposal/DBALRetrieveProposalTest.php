<?php

declare (strict_types=1);

namespace App\Tests\ForSendProposals\ReadProposal;

use App\ForSendProposals\ReadProposal\RetrieveProposal\DataNotFound;
use App\ForSendProposals\ReadProposal\RetrieveProposal\DBALRetrieveProposal;
use App\ForSendProposals\ReadProposal\RetrieveProposal\ReadingProposalException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Result;
use PHPUnit\Framework\TestCase;

final class DBALRetrieveProposalTest extends TestCase
{
    /** @test */
    public function should_manage_DBALException(): void
    {
        $connection = $this->createMock(Connection::class);

        $dbalRetrieveProposal = new DBALRetrieveProposal($connection);

        $builder = $this->createMock(QueryBuilder::class);
        $builder->method('select')->willReturn($builder);
        $builder->method('from')->willReturn($builder);
        $builder->method('where')->willReturn($builder);
        $builder->method('setParameter')->willReturn($builder);
        $builder->method('executeQuery')->willThrowException(new Exception('some exception'));

        $connection->method('createQueryBuilder')->willReturn($builder);

        $this->expectException(ReadingProposalException::class);
        ($dbalRetrieveProposal)('01HYGW7NKM6JGGQ9NM2A4VY5SG');
    }

    /** @test */
    public function should_manage_DBALException_in_result(): void
    {
        $connection = $this->createMock(Connection::class);
        $dbalRetrieveProposal = new DBALRetrieveProposal($connection);

        $result = $this->createMock(Result::class);
        $result->method('fetchAssociative')->willThrowException(new Exception('some exception'));

        $builder = $this->createMock(QueryBuilder::class);
        $builder->method('select')->willReturn($builder);
        $builder->method('from')->willReturn($builder);
        $builder->method('where')->willReturn($builder);
        $builder->method('setParameter')->willReturn($builder);
        $builder->method('executeQuery')->willReturn($result);

        $connection->method('createQueryBuilder')->willReturn($builder);

        $this->expectException(ReadingProposalException::class);
        ($dbalRetrieveProposal)('01HYGW7NKM6JGGQ9NM2A4VY5SG');
    }

    /** @test */
    public function should_manage_Exception_in_result(): void
    {
        $connection = $this->createMock(Connection::class);
        $dbalRetrieveProposal = new DBALRetrieveProposal($connection);

        $rawProposal = [
            'id' => '01HYJ6FZ92VTV6RWG7JYBJK0KE',
            'title' => 'Proposal Title',
            'description' => 'Brief description of the content',
            'author' => 'Fran Iglesias',
            'email' => 'fran.iglesias@example.com',
            'type' => 'talk',
            'sponsored' => false,
            'location' => 'Vigo, Galicia',
            'status' => 'waiting',
            'received_at' => 'xxx',
        ];

        $result = $this->createMock(Result::class);
        $result->method('fetchAssociative')->willReturn($rawProposal);

        $builder = $this->createMock(QueryBuilder::class);
        $builder->method('select')->willReturn($builder);
        $builder->method('from')->willReturn($builder);
        $builder->method('where')->willReturn($builder);
        $builder->method('setParameter')->willReturn($builder);
        $builder->method('executeQuery')->willReturn($result);

        $connection->method('createQueryBuilder')->willReturn($builder);

        $this->expectException(ReadingProposalException::class);
        ($dbalRetrieveProposal)('01HYGW7NKM6JGGQ9NM2A4VY5SG');
    }

    /** @test */
    public function should_manage_no_result(): void
    {
        $connection = $this->createMock(Connection::class);
        $dbalRetrieveProposal = new DBALRetrieveProposal($connection);

        $result = $this->createMock(Result::class);
        $result->method('fetchAssociative')->willReturn(false);

        $builder = $this->createMock(QueryBuilder::class);
        $builder->method('select')->willReturn($builder);
        $builder->method('from')->willReturn($builder);
        $builder->method('where')->willReturn($builder);
        $builder->method('setParameter')->willReturn($builder);
        $builder->method('executeQuery')->willReturn($result);

        $connection->method('createQueryBuilder')->willReturn($builder);

        $this->expectException(DataNotFound::class);
        ($dbalRetrieveProposal)('01HYGW7NKM6JGGQ9NM2A4VY5SG');
    }
}
