<?php

namespace App\Command;

use App\Field\GameFieldInterface;

use App\Manager\GameManager;

use Doctrine\ORM\EntityManagerInterface;

use App\Service\Unibet\EventService;
use App\Service\Unibet\RefreshService;
use App\Service\Unibet\CalendarService;

use Symfony\Component\Console\Input\InputInterface;

use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\Console\Command\Command;

use Symfony\Component\Console\Question\Question;

class RefreshEvents extends Command
{
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
        EntityManagerInterface $em,
        GameManager $gameManager,
        RefreshService $refreshService
    ) {
        $this->em = $em;
        $this->gameManager = $gameManager;
        $this->refreshService = $refreshService;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:events:refresh')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $response = $this->refreshService->refresh();
        $liveGames = json_decode($response->getBody()->getContents(), true)['rows'];

        foreach ($liveGames as $liveGame) {
            $eventId = $liveGame[GameFieldInterface::EVENT_ID];
            // dump($eventId);
            if (null !== $game = $this->gameManager->get($eventId)) {
                dump($game->getUnibetId());
            }
        }
    }
}
