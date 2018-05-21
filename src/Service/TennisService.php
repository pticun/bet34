<?php

namespace App\Service;

use App\Manager\TennisManager;
use stdClass;

class TennisService
{
    /**
     * @var SetService
     */
    private $setService;

    /**
     * @var TennisManager
     */
    private $tennisManager;

    public function __construct(
        SetService $setService,
        TennisManager $tennisManager
    ) {
        $this->setService = $setService;
        $this->tennisManager = $tennisManager;
    }

    public function process(stdClass $row): void
    {
        $unibetId = $row->eventId;
        $match = $this->tennisManager->getOrGenerate($unibetId, $row);
        $sets = $this->setService->mapSets($match, $row);
    }
}
