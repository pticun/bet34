<?php

namespace App\Repository;

use App\Entity\Set;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Set|null find($id, $lockMode = null, $lockVersion = null)
 * @method Set|null findOneBy(array $criteria, array $orderBy = null)
 * @method Set[]    findAll()
 * @method Set[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Set::class);
    }
}
