<?php

namespace App\Repository;

use App\Entity\Topic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Topic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Topic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Topic[]    findAll()
 * @method Topic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TopicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Topic::class);
    }

    public function findTopics(array $topics) {
        return $this->createQueryBuilder('t')
            ->andWhere('t.id in (:topics)')
            ->setParameter('topics', $topics)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Topic[] Returns an array of Topic objects
     */
    public function findTopicsOrdererQB($locale = 'es')
    {
        $qb = $this->createQueryBuilder('t');
        if ($locale === 'es') {
            $qb->orderBy('t.descriptionEs', 'ASC');
        } else {
            $qb->orderBy('t.descriptionEu', 'ASC');
        }
        return $qb;
    }

    /*
    public function findOneBySomeField($value): ?Topic
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
