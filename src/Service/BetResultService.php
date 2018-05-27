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
        foreach ($this->getResultTexts() as $text) {
            if (false !== strpos($eventFact['displayText'], $this->getSuccessText($bet, $text))) {
                return true;
            }
        }

        return false;
    }

    private function isFailed(Bet $bet, array $eventFact): bool
    {
        foreach ($this->getResultTexts() as $text) {
            if (false !== strpos($eventFact['displayText'], $this->getFailedText($bet, $text))) {
                return true;
            }
        }

        return false;
    }

    private function getSuccessText(Bet $bet, string $text): string
    {
        return sprintf(
            $text,
            BetHelper::getCurrentSetNumber($bet),
            BetHelper::getCurrentGameNumber($bet),
            BetHelper::getPlayerName($bet)
        );
    }

    private function getFailedText(Bet $bet, string $text): string
    {
        return sprintf(
            BetHelper::getCurrentSetNumber($bet),
            BetHelper::getCurrentGameNumber($bet),
            BetHelper::getOpponentName($bet)
        );
    }

    private function getResultTexts(): array
    {
        return [
            'Set %d, Jeu %d : %s',
            'Set %d, Jeu %d : Break pour %s',
        ];
    }
}
