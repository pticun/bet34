<?php

namespace App\Manager;

use App\Field\GameFieldInterface;

use App\Entity\Game;

use App\Helper\Chrono;

use Doctrine\ORM\EntityManagerInterface;

class GameManager implements ManagerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(
        EntityManagerInterface $em
    ) {
        $this->em = $em;
    }

    public function generate(array $data = []): Game
    {
        $game = new Game();
        $game->setUnibetId($data[GameFieldInterface::EVENT_ID]);
        $game->setName($data[GameFieldInterface::EVENT_NAME]);
        $game->setSport($data[GameFieldInterface::SPORT]);
        $game->setHomeTeamName($data[GameFieldInterface::EVENT_HOME_TEAM_NAME]);
        $game->setAwayTeamName($data[GameFieldInterface::EVENT_AWAY_TEAM_NAME]);
        $game->setUrl($data[GameFieldInterface::URL]);

        return $game;
    }

    public function persist(array $data = []): Game
    {
        $game = $this->generate($data);
        $this->em->persist($game);

        return $game;
    }

    public function getOrPersist(array $data = []): Game
    {
        if (null !== $game = $this->get($data[GameFieldInterface::EVENT_ID])) {
            return $game;
        }

        return $this->persist($data);
    }

    public function get(string $eventId): ?Game
    {
        return $this->em->getRepository(Game::class)->findOneBy([
            'unibetId' => $eventId
        ]);
    }

    public function updateScore(Game $game, int $homeScore, int $awayScore): Game
    {
        $game->setHomeScore($homeScore);
        $game->setAwayScore($awayScore);

        return $game;
    }

    public function updateChrono(Game $game, string $chrono, string $period): Game
    {
        $game->setChrono(Chrono::extractChrono($chrono));
        $game->setPeriod($period);

        return $game;
    }

    private function getDateTimeFromMicrotime(int $timestamp): \DateTime
    {
        $datetime = new \DateTime();
        $datetime->setTimestamp($timestamp/1000);

        return $datetime;
    }
}
