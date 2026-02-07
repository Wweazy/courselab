<?php

namespace App\Repository;

use App\Entity\Course;
use App\Entity\Purchase;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PurchaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Purchase::class);
    }

    public function findOneByUserAndCourse(User $user, Course $course): ?Purchase
    {
        return $this->findOneBy([
            'user' => $user,
            'course' => $course,
        ]);
    }
}
