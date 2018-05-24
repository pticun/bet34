<?php

namespace App\Service;

use App\Entity\Bet;
use App\Helper\BetHelper;
use App\Service\Unibet\EventFactsService;

class BetResultService
{
    /**
     * @var EventFactsService
     */
    private $eventFactsService;

    public function __construct(EventFactsService $eventFactsService)
    {
        $this->eventFactsService = $eventFactsService;
    }

    public function getResultForBet(Bet $bet): ?bool
    {
        $eventFacts = $this->eventFactsService->getEventFacts($bet->getSet()->getMatch()->getUnibetId());

        foreach ($eventFacts as $eventFact) {
            if ($this->isSuccessed($bet, $eventFact)) {
                return true;
            }

            if ($this->isFailed($bet, $eventFact)) {
                return false;
            }
        }

        return null;
    }

    private function isSuccessed(Bet $bet, array $eventFact): bool
    {
        return false !== strpos($eventFact['displayText'], $this->getSuccessText($bet));
    }

    private function isFailed(Bet $bet, array $eventFact): bool
    {
        return false !== strpos($eventFact['displayText'], $this->getFailedText($bet));
    }

    private function getSuccessText(Bet $bet): string
    {
        return sprintf(
            'Set %d, Jeu %d : %s',
            BetHelper::getCurrentSetNumber($bet),
            BetHelper::getCurrentGameNumber($bet),
            BetHelper::getPlayerName($bet)
        );
    }

    private function getFailedText(Bet $bet): string
    {
        return sprintf(
            'Set %d, Jeu %d : Break pour %s',
            BetHelper::getCurrentSetNumber($bet),
            BetHelper::getCurrentGameNumber($bet),
            BetHelper::getOpponentName($bet)
        );
    }
}
