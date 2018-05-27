<?php

namespace App\Validator;

use App\Entity\Bet;
use App\Manager\BetManager;
use App\Manager\SetManager;
use App\Service\BreakService;

class BetValidator
{
    /**
     * @var BetManager
     */
    private $betManager;

    /**
     * @var BreakService
     */
    private $breakService;

    /**
     * @var SetManager
     */
    private $setManager;

    public function __construct(
        BetManager $betManager,
        BreakService $breakService,
        SetManager $setManager
    ) {
        $this->betManager = $betManager;
        $this->breakService = $breakService;
        $this->setManager = $setManager;
    }

    public function shouldProcess(Bet $bet): bool
    {
        if (!$bet->isTradable()) {
            return false;
        }

        if (!$this->isValidRank($bet)) {
            return false;
        }

        if (!$this->isPositionToWinner($bet)) {
            return false;
        }
        //
        // if (!$this->isValidPoint($bet)) {
        //     return false;
        // }
        //
        // if (!$this->hasBreak($bet)) {
        //     return false;
        // }
        //
        // if (!$this->isFirstGameBet($bet)) {
        //     return false;
        // }
        //
        // if ($this->breakService->hasBeenBreaked($bet)) {
        //     return false;
        // }

        return true;
    }

    private function isValidRank(Bet $bet): bool
    {
        return
            1.35 <= $bet->getRank() &&
            1.50 >= $bet->getRank()
        ;
    }

    private function isPositionToWinner(Bet $bet): bool
    {
        return
            ('HOME' === $bet->getPosition() && $bet->getHomeScore() > $bet->getAwayScore()) ||
            ('AWAY' === $bet->getPosition() && $bet->getHomeScore() < $bet->getAwayScore())
        ;
    }

    private function isValidPoint(Bet $bet): bool
    {
        return
            $bet->getHomePoint() === $bet->getAwayPoint() &&
            (
                '0' === $bet->getHomePoint() ||
                '15' === $bet->getAwayPoint()
            )
        ;
    }

    private function isFirstGameBet(Bet $bet): bool
    {
        return null === $this->betManager->get($bet->getSet());
    }

    private function hasBreak(Bet $bet): bool
    {
        if ('HOME' === $bet->getPosition()) {
            return
                (2 <= ($bet->getHomeScore() - $bet->getAwayScore())) ||
                (
                    1 <= ($bet->getHomeScore() - $bet->getAwayScore()) &&
                    1.25 > $bet->getRank()
                )
            ;
        }

        return
            (2 <= ($bet->getAwayScore() - $bet->getHomeScore())) ||
            (
                1 <= ($bet->getAwayScore() - $bet->getHomeScore()) &&
                1.25 > $bet->getRank()
            )
        ;
    }
}
