<?php

namespace App\Manager;

use App\Field\GameFieldInterface;
use App\Field\MarketFieldInterface;

use App\Entity\Bet;
use App\Entity\Game;

use App\Repository\BetRepository;

use Doctrine\ORM\EntityManagerInterface;

class BetManager implements ManagerInterface
{
    /**
     * @var BetRepository
     */
    private $betRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(BetRepository $betRepository, EntityManagerInterface $em)
    {
        $this->betRepository = $betRepository;
        $this->em = $em;
    }

    public function persistBet(Game $gameEntity, array $market, array $game): Bet
    {
        $bet = new Bet();
        $bet->setGame($gameEntity);
        $bet->setMarketName($market[MarketFieldInterface::MARKET_NAME]);
        $bet->setHomeScore($game[GameFieldInterface::SCORE][GameFieldInterface::EVENT_HOME_SCORE]);
        $bet->setAwayScore($game[GameFieldInterface::SCORE][GameFieldInterface::EVENT_AWAY_SCORE]);
        $bet->setChrono($game[GameFieldInterface::CHRONO][GameFieldInterface::CHRONO_VALUE]);
        $bet->setPeriod($game[GameFieldInterface::CHRONO][GameFieldInterface::CHRONO_PERIOD]);

        $selections = $market[MarketFieldInterface::SELECTIONS];
        foreach ($selections as $selection) {
            $this->handleSelection($bet, $selection);
        }

        $this->em->persist($bet);

        return $bet;
    }

    private function handleSelection(Bet $bet, array $selection): void
    {
        $rate = $this->getRate($selection[MarketFieldInterface::SELECTION_CURRENT_PRICE_UP], $selection[MarketFieldInterface::SELECTION_CURRENT_PRICE_DOWN]);
        if (MarketFieldInterface::HOME_HAD_VALUE === $selection[MarketFieldInterface::SELECTION_HAD_VALUE]) {
            $bet->setHomeSelectionName($selection[MarketFieldInterface::SELECTION_NAME]);
            $bet->setHomeRate($rate);
        }

        if (MarketFieldInterface::DRAW_HAD_VALUE === $selection[MarketFieldInterface::SELECTION_HAD_VALUE]) {
            $bet->setDrawRate($rate);
        }

        if (MarketFieldInterface::AWAY_HAD_VALUE === $selection[MarketFieldInterface::SELECTION_HAD_VALUE]) {
            $bet->setAwaySelectionName($selection[MarketFieldInterface::SELECTION_NAME]);
            $bet->setAwayRate($rate);
        }

        return;
    }

    private function getRate(int $currentPriceUp, int $currentPriceDown): float
    {
        return ($currentPriceUp+$currentPriceDown)/ $currentPriceDown;
    }
}
