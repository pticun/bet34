<?php

namespace App\Command;

use App\Service\TennisService;
use App\Service\Unibet\RefreshService;
use Doctrine\ORM\EntityManagerInterface;
use stdClass;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Live extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var TennisService
     */
    private $tennisService;

    /**
     * @var RefreshService
     */
    private $refreshService;

    public function __construct(
        EntityManagerInterface $em,
        TennisService $tennisService,
        RefreshService $refreshService
    ) {
        $this->em = $em;
        $this->tennisService = $tennisService;
        $this->refreshService = $refreshService;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:games:live')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $rows = $this->refreshService->refresh();

        $eventIds = [];
        foreach ($rows as $row) {
            if (!$this->shouldProcessGame($row)) {
                continue;
            }

            $eventIds[] = $row->eventId;
            $this->tennisService->process($row);
        }

        $this->em->flush();
    }

    private function shouldProcessGame(stdClass $row): bool
    {
        return 'TENNIS' === $row->sport;
    }
}
