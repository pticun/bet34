<?php

namespace App\Service;

use App\Entity\Bet;
use App\Service\Unibet\EventFactsService;

class BreakService
{
    /**
     * @var EventFactsService
     */
    private $eventFactsService;

    public function __construct(EventFactsService $eventFactsService)
    {
        $this->eventFactsService = $eventFactsService;
    }

    public function hasBeenBreaked(Bet $bet): bool
    {
        $eventFacts = $this->eventFactsService->getEventFacts($bet->getSet()->getMatch()->getUnibetId());
        $breakText = $this->getBreakText($bet);
        foreach ($eventFacts as $eventFact) {
            if ($this->breakTextFound($eventFact['displayText'], $breakText)) {
                return true;
            }
        }

        return false;
    }

    private function breakTextFound(string $eventText, string $breakText): bool
    {
        return false !== strpos($eventText, $breakText);
    }

    private function getBreakText(Bet $bet): string
    {
        return sprintf('Break pour %s', $this->getOpponentPlayerNameFromPosition($bet));
    }

    private function getOpponentPlayerNameFromPosition(Bet $bet): string
    {
        if ('HOME' === $bet->getPosition()) {
            return $bet->getSet()->getMatch()->getAwayName();
        }

        return $bet->getSet()->getMatch()->getHomeName();
    }
}
