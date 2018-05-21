<?php

namespace App\Manager;

use App\Entity\Match;
use App\Entity\Set;
use App\Entity\Tennis;
use Doctrine\ORM\EntityManagerInterface;
use stdClass;

class SetManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function get(Tennis $match, int $index): ?Set
    {
        return $this->em->getRepository(Set::class)->findOneBy([
            'match' => $match,
            'order' => $index,
        ]);
    }

    public function getLast(Tennis $match): ?Set
    {
        return $this->em->getRepository(Set::class)->findOneBy([
            'match' => $match,
        ], [
            'order' => 'DESC',
        ]);
    }

    public function generate(Tennis $match, int $index, stdClass $row): Set
    {
        $set = new Set();
        $set->setMatch($match);
        $set->setHomeScore($row->score->homePartialScore[$index]);
        $set->setAwayScore($row->score->awayPartialScore[$index]);
        $set->setOrder($index);

        if (!$this->isCurrentSet($index, $row)) {
            return $set;
        }

        $this->setCurrentPosition($set, $row);

        return $set;
    }

    public function update(Set $set, stdClass $row): Set
    {
        return $this->setCurrentPosition($set, $row);
    }

    private function setCurrentPosition(Set $set, stdClass $row): Set
    {
        $set->setHomePoint($row->score->homeCurrentPoint);
        $set->setAwayPoint($row->score->awayCurrentPoint);
        $set->setPosition($row->score->currentPosition);

        return $set;
    }

    private function isCurrentSet(int $index, stdClass $row): bool
    {
        return ($index + 1) === count($row->score->homePartialScore);
    }
}
