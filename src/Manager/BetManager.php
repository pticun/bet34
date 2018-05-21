<?php

namespace App\Manager;

use App\Entity\Bet;
use App\Entity\Set;
use Doctrine\ORM\EntityManagerInterface;
use stdClass;

class BetManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function get(Set $set): ?Bet
    {
        return $this->em->getRepository(Bet::class)->findOneBy([
            'set' => $set,
            'homeScore' => $set->getHomeScore(),
            'awayScore' => $set->getAwayScore(),
        ]);
    }

    public function generate(Set $set, stdClass $row, string $selectionId, string $selectionName, float $rank): Bet
    {
        $bet = new Bet();
        $bet->setSet($set);
        $bet->setMarketType($row->markettype);
        $bet->setMarketId($row->marketId);
        $bet->setRank($rank);
        $bet->setHomeScore($set->getHomeScore());
        $bet->setAwayScore($set->getAwayScore());
        $bet->setHomePoint($set->getHomePoint());
        $bet->setAwayPoint($set->getAwayPoint());
        $bet->setPosition($set->getPosition());
        $bet->setTradable($row->istradable);
        $bet->setSelectionId($selectionId);
        $bet->setSelectionName($selectionName);

        return $bet;
    }

    public function persist(Bet $bet): void
    {
        $match = $bet->getSet()->getMatch();
        $set = $bet->getSet();

        if (null === $match->getId()) {
            $this->em->persist($match);
        }

        if (null === $set->getId()) {
            $this->em->persist($set);
        }

        $this->em->persist($bet);
    }
}
