<?php

namespace App\Service;

use App\Entity\Set;
use App\Entity\Tennis;
use App\Manager\SetManager;
use stdClass;

class SetService
{
    /**
     * @var SetManager
     */
    private $setManager;

    public function __construct(
        SetManager $setManager
    ) {
        $this->setManager = $setManager;
    }

    public function mapSets(Tennis $match, stdClass $row): array
    {
        $homeScores = $row->score->homePartialScore;
        $awayScores = $row->score->awayPartialScore;

        $sets = [];
        foreach ($homeScores as $index => $score) {
            $sets[] = $this->mapSet($match, $index, $homeScores[$index], $awayScores[$index], $row);
        }

        return $sets;
    }

    private function mapSet(Tennis $match, int $index, string $homeScore, string $awayScore, stdClass $row): Set
    {
        if (null !== $match->getId() && null !== $set = $this->setManager->get($match, $index)) {
            return $this->setManager->update($set, $row);
        }

        return $this->setManager->generate($match, $index, $row);
    }
}
