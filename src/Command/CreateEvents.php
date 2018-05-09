<?php

namespace App\Command;

use App\Field\GameFieldInterface;
use App\Field\MarketFieldInterface;

use App\Manager\BetManager;
use App\Manager\GameManager;

use Doctrine\ORM\EntityManagerInterface;

use App\Service\Unibet\EventService;
use App\Service\Unibet\RefreshService;
use App\Service\Unibet\CalendarService;

use Symfony\Component\Console\Input\InputInterface;

use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Command\Command;

use Symfony\Component\Console\Question\Question;

class CreateEvents extends Command
{
    /**
     * @var BetManager
     */
    private $betManager;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var GameManager
     */
    private $gameManager;

    /**
     * @var RefreshService
     */
    private $refreshService;

    public function __construct(
        BetManager $betManager,
        EntityManagerInterface $em,
        GameManager $gameManager,
        RefreshService $refreshService
    ) {
        $this->betManager = $betManager;
        $this->em = $em;
        $this->gameManager = $gameManager;
        $this->refreshService = $refreshService;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:games:foot:live')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $response = $this->refreshService->refresh();
        $games = json_decode($response->getBody()->getContents(), true)['rows'];


        foreach ($games as $game) {
            if (!$this->shouldProcessGame($game)) {
                continue;
            }

            $gameEntity = $this->gameManager->getOrPersist($game);
            $this->gameManager->updateScore(
                $gameEntity,
                $game[GameFieldInterface::SCORE][GameFieldInterface::EVENT_HOME_SCORE],
                $game[GameFieldInterface::SCORE][GameFieldInterface::EVENT_AWAY_SCORE]
            );

            $this->gameManager->updateChrono(
                $gameEntity,
                $game[GameFieldInterface::CHRONO][GameFieldInterface::CHRONO_VALUE],
                $game[GameFieldInterface::CHRONO][GameFieldInterface::CHRONO_PERIOD]
            );

            $markets = $game['marketlist']['rows'];
            foreach ($markets as $market) {
                if (!$this->shouldProcessMarket($market)) {
                    continue;
                }

                $bet = $this->betManager->persistBet(
                    $gameEntity,
                    $market,
                    $game
                );
            }
        }
        $this->em->flush();
    }

    private function shouldProcessGame(array $game = []): bool
    {
        return 'FOOTBALL' === $game[GameFieldInterface::SPORT_TYPE];
    }

    private function shouldProcessMarket(array $market = []): bool
    {
        return 'Match Result' === $market[MarketFieldInterface::MARKET_TYPE];
    }
}
