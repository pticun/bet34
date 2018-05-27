<?php

namespace App\Command;

use App\Service\TennisService;
use App\Service\Unibet\RefreshService;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
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
     * @var LoggerInterface
     */
    private $logger;

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
        LoggerInterface $logger,
        TennisService $tennisService,
        RefreshService $refreshService
    ) {
        $this->em = $em;
        $this->logger = $logger;
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
        $this->logger->critical('start refresh');
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
