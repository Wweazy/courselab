<?php

namespace App\Repository;

use App\Entity\Course;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class CourseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Course::class);
    }

    public function findByCategoryId(?int $categoryId): array
    {
        if (!$categoryId) {
            return $this->findAll();
        }

        return $this->createQueryBuilder('c')
            ->andWhere('c.category = :categoryId')
            ->setParameter('categoryId', $categoryId)
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
