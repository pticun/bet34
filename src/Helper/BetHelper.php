<?php

namespace App\Helper;

use App\Entity\Bet;

class BetHelper
{
    public static function getPlayerName(Bet $bet): string
    {
        if ('HOME' === $bet->getPosition()) {
            return $bet->getSet()->getMatch()->getHomeName();
        }

        return $bet->getSet()->getMatch()->getAwayName();
    }

    public static function getOpponentName(Bet $bet): string
    {
        if ('HOME' === $bet->getPosition()) {
            return $bet->getSet()->getMatch()->getAwayName();
        }

        return $bet->getSet()->getMatch()->getHomeName();
    }

    public static function getCurrentSetNumber(Bet $bet): int
    {
        return 1 + $bet->getSet()->getOrder();
    }

    public static function getCurrentGameNumber(Bet $bet): int
    {
        return 1 + $bet->getHomeScore() + $bet->getAwayScore();
    }
}
