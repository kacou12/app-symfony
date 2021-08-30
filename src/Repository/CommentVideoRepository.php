<?php

namespace App\Repository;

use App\Entity\CommentVideo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommentVideo|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentVideo|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentVideo[]    findAll()
 * @method CommentVideo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentVideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentVideo::class);
    }

    // /**
    //  * @return CommentVideo[] Returns an array of CommentVideo objects
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
    public function findOneBySomeField($value): ?CommentVideo
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
