<?php

namespace App\Repository;

use App\Entity\ProjectLink;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProjectLink>
 *
 * @method ProjectLink|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectLink|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectLink[]    findAll()
 * @method ProjectLink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectLinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectLink::class);
    }

//    /**
//     * @return ProjectLink[] Returns an array of ProjectLink objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ProjectLink
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
