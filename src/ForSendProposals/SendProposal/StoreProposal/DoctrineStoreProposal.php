<?php

declare (strict_types=1);

namespace App\ForSendProposals\SendProposal\StoreProposal;


use App\ForSendProposals\SendProposal\Proposal;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

final class DoctrineStoreProposal implements StoreProposal
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(Proposal $proposal): void
    {
        $this->em->beginTransaction();
        try {
            $this->em->persist($proposal);
            $this->em->flush();
            $this->em->commit();
        } catch (Exception $e) {
            $this->em->rollback();
            throw new ProposalNotStored("Proposal could not be stored", 1, $e);
        }
    }
}
