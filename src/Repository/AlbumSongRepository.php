<?php

namespace App\Repository;

use App\Entity\AlbumSong;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AlbumSong>
 *
 * @method AlbumSong|null find($id, $lockMode = null, $lockVersion = null)
 * @method AlbumSong|null findOneBy(array $criteria, array $orderBy = null)
 * @method AlbumSong[]    findAll()
 * @method AlbumSong[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlbumSongRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AlbumSong::class);
    }

//    /**
//     * @return AlbumSong[] Returns an array of AlbumSong objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AlbumSong
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
