<?php

declare (strict_types=1);

namespace App\ForSendProposals\ReadProposal;


use DateTimeImmutable;
use Doctrine\DBAL\Connection;

final class DBALRetrieveProposal implements RetrieveProposal
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }


    public function __invoke(string $id): Proposal
    {
        $builder = $this->connection->createQueryBuilder();

        $query = $builder->select(
            'id',
            'title',
            'description',
            'author',
            'email',
            'sponsored',
            'type',
            'location',
            'status',
            'received_at'
        )
            ->from('proposal')
            ->where('id = ?')
            ->setParameter(0, $id);

        $result = $query->executeQuery();

        $readProposal = $result->fetchAssociative();

        return new Proposal(
            $readProposal['id'],
            $readProposal['title'],
            $readProposal['description'],
            $readProposal['author'],
            $readProposal['email'],
            $readProposal['type'],
            $readProposal['sponsored'],
            $readProposal['location'],
            $readProposal['status'],
            new DateTimeImmutable($readProposal['received_at'])
        );
    }
}
