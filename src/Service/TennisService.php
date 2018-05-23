<?php

namespace App\Service;

use App\Entity\Set;
use App\Manager\BetManager;
use App\Manager\TennisManager;
use App\Validator\BetValidator;
use stdClass;

class TennisService
{
    /**
     * @var BetManager
     */
    private $betManager;

    /**
     * @var BetValidator
     */
    private $betValidator;

    /**
     * @var SetService
     */
    private $setService;

    /**
     * @var TennisManager
     */
    private $tennisManager;

    public function __construct(
        BetManager $betManager,
        BetValidator $betValidator,
        SetService $setService,
        TennisManager $tennisManager
    ) {
        $this->betManager = $betManager;
        $this->betValidator = $betValidator;
        $this->setService = $setService;
        $this->tennisManager = $tennisManager;
    }

    public function process(stdClass $row): void
    {
        $match = $this->tennisManager->getOrGenerate($row);
        $sets = $this->setService->mapSets($match, $row);

        if (null === $currentSet = $this->getCurrentSet($sets)) {
            return;
        }

        if (null === $market = $this->getMarket($currentSet, $row)) {
            return;
        }

        if (null !== $this->betManager->get($currentSet)) {
            return;
        }

        foreach ($market->selections as $selection) {
            $rank = $this->getRank($selection->currentPriceUp, $selection->currentPriceDown);
            $bet = $this->betManager->generate(
                $currentSet,
                $market,
                $selection->selectionId,
                $selection->name,
                $rank
            );

            if ($this->betValidator->shouldProcess($bet)) {
                $this->betManager->persist($bet, $sets);
            }
        }
    }

    private function getCurrentSet(array $sets): ?Set
    {
        $index = (count($sets) - 1);

        foreach ($sets as $set) {
            if ($index === $set->getOrder()) {
                return $set;
            }
        }

        return null;
    }

    private function getMarket(Set $set, stdClass $row): ?stdClass
    {
        $markets = $row->marketlist->rows;
        foreach ($markets as $market) {
            if ($this->getMarketType($set) === $market->markettype) {
                return $market;
            }
        }

        return null;
    }

    private function getMarketType(Set $set): string
    {
        $game = 1 + $set->getHomeScore() + $set->getAwayScore();

        return sprintf('Game Winner (Set %d, Game %d)', $set->getOrder() + 1, $game);
    }

    private function getRank(int $currentPriceUp, int $currentPriceDown): float
    {
        return number_format(($currentPriceUp + $currentPriceDown) / $currentPriceDown, 2);
    }
}
