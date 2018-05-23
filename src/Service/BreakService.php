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

    public function hasBeenBreakedDuringSet(Bet $bet): bool
    {
        // $eventFacts = $this->eventFactsService->getEventFacts($bet->getSet()->getMatch()->getUnibetId());

        return false;
    }
}
