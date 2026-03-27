<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Theme;
use App\Entity\UserLesson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserLessonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserLesson::class);
    }

    public function countValidatedLessons(User $user, Theme $theme): int
    {
        return (int) $this->createQueryBuilder('ul')
            ->select('COUNT(ul.id)')
            ->join('ul.lesson', 'l')
            ->join('l.cursus', 'c')
            ->join('c.themes', 't')
            ->where('ul.user = :user')
            ->andWhere('t = :theme')
            ->andWhere('ul.isValidated = true')
            ->setParameter('user', $user)
            ->setParameter('theme', $theme)
            ->getQuery()
            ->getSingleScalarResult();
    }
}