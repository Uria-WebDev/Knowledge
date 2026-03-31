<?php

namespace App\Repository;

use App\Entity\Lesson;
use App\Entity\Theme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Lesson>
 */
class LessonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lesson::class);
    }

    public function countLessonsByCursus(Cursus $cursus): int
    {
        return (int) $this->createQueryBuilder('l')
            ->select('COUNT(l.id)')
            ->join('l.cursus', 'c')
            ->where('c = :cursus')
            ->setParameter('cursus', $cursus)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countLessonsByTheme(Theme $theme): int
    {
        return (int) $this->createQueryBuilder('l')
            ->select('COUNT(l.id)')
            ->join('l.cursus', 'c')
            ->join('c.themes', 't')
            ->where('t = :theme')
            ->setParameter('theme', $theme)
            ->getQuery()
            ->getSingleScalarResult();
    }

    //    /**
    //     * @return Lesson[] Returns an array of Lesson objects
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

    //    public function findOneBySomeField($value): ?Lesson
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}