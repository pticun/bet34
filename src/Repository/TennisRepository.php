<?php

namespace App\Repository;

use App\Entity\Tennis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Tennis|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tennis|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tennis[]    findAll()
 * @method Tennis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TennisRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tennis::class);
    }
}
