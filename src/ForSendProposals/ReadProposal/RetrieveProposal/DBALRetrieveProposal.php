<?php

declare (strict_types=1);

namespace App\ForSendProposals\ReadProposal\RetrieveProposal;


use App\ForSendProposals\ReadProposal\Proposal;
use DateMalformedStringException;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception as DBALException;
use Exception;

final class DBALRetrieveProposal implements RetrieveProposal
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }


    /**
     * @throws ReadingProposalException
     */
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

        try {
            $result = $query->executeQuery();
        } catch (DBALException $e) {
            throw new ReadingProposalException('Query to DB failed', 1, $e);
        }

        try {
            $readProposal = $result->fetchAssociative();
        } catch (DBALException $e) {
            // Change the exception type if you need more resolution here
            throw new ReadingProposalException('Failed extracting data from result',
                2, $e);
        }

        try {
            $proposal = new Proposal(
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
        } catch (DateMalformedStringException|Exception $e) {
            throw new ReadingProposalException('Data could be corrupted', 3,
                $e);
        }

        return $proposal;
    }
}
