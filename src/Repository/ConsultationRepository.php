<?php

namespace App\Repository;

use App\Entity\Consultation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Consultation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Consultation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Consultation[]    findAll()
 * @method Consultation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConsultationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Consultation::class);
    }

    /**
     * @return Consultation[] Returns an array of Consultation objects
     */
    public function findByConsultationFilter(Consultation $consultation, int $maxResults = 100)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->innerJoin('c.topic', 't');
        if ($consultation->getStartDate() !== null) {
            $qb->andWhere('c.startDate >= :startDate');
            $qb->setParameter('startDate', $consultation->getStartDate());
        }
        if ($consultation->getEndDate() !== null) {
            $qb->andWhere('c.endDate <= :endDate');
            $qb->setParameter('endDate', $consultation->getEndDate());
        }
        if (count($consultation->getTopic()->toArray()) > 0) {
            $qb->andWhere('t.id IN (:topic)');
            $qb->setParameter('topic', $consultation->getTopic()->toArray());
        }
        $qb->orderBy('c.id', 'DESC');
        $qb->setMaxResults($maxResults);
        $qb->getQuery();
        $result = $qb->getQuery()->getResult();
        //        dd($qb->getQuery(), $result);
        return $result;
    }


    // /**
    //  * @return Consultation[] Returns an array of Consultation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Consultation
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
