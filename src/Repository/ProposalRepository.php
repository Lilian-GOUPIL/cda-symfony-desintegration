<?php

namespace App\Repository;

use App\Entity\Proposal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Proposal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Proposal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Proposal[]    findAll()
 * @method Proposal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProposalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Proposal::class);
    }

    /**
     * @return Proposal[]
     */
    public function findWinner()
    {
        /**
         * SELECT *, COUNT(proposal_user.proposal_id) AS nbVotes FROM proposal INNER JOIN proposal_user ON proposal.id = proposal_user.proposal_id GROUP BY proposal.id HAVING nbVotes = (
         *     SELECT COUNT(proposal_user.proposal_id) AS nbVotes FROM proposal INNER JOIN proposal_user ON proposal.id = proposal_user.proposal_id GROUP BY proposal.id ORDER BY nbVotes DESC LIMIT 1
         * );
         */

        if (sizeof($this->findAll()) === 0) {
            return null;
        } else {
            return $this->createQueryBuilder('p')
                ->addSelect('COUNT(u) as nbVotes')
                ->join('p.votedBy', 'u')
                ->groupBy('p.id')
                ->having('COUNT(nbVotes) = ' . $this->createQueryBuilder('p')
                    ->addSelect('COUNT(u) as nbVotes')
                    ->leftJoin('p.votedBy', 'u')
                    ->groupBy('p.id')
                    ->orderBy('nbVotes', 'DESC')
                    ->setMaxResults(1)
                    ->getQuery()
                    ->getResult()[0]['nbVotes']
                )
                ->getQuery()
                ->getResult();
        }
    }

    // /**
    //  * @return Proposal[] Returns an array of Proposal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Proposal
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
