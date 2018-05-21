<?php

namespace App\Manager;

use App\Entity\Tennis;
use Doctrine\ORM\EntityManagerInterface;
use stdClass;

class TennisManager implements ManagerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function generate(stdClass $row): Tennis
    {
        $match = new Tennis();
        $match->setName($row->name);
        $match->setCompetitionName($row->competitionName);
        $match->setUnibetId($row->eventId);
        $match->setHomeName($row->homeName);
        $match->setHomeShortName($row->homeShortName);
        $match->setAwayName($row->awayName);
        $match->setAwayShortName($row->awayShortName);
        $this->em->persist($match);

        return $match;
    }

    public function get(string $unibetId): ?Tennis
    {
        return $this->em->getRepository(Tennis::class)->findOneBy(['unibetId' => $unibetId]);
    }

    public function getOrGenerate(string $unibetId, stdClass $row): Tennis
    {
        if (null !== $match = $this->get($unibetId)) {
            return $match;
        }

        return $this->generate($row);
    }
}
