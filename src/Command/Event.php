<?php

namespace App\Command;

use App\Service\Unibet\EventFactsService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Event extends Command
{
    /**
     * @var EventFactsService
     */
    private $eventFactsService;

    public function __construct(
        EventFactsService $eventFactsService
    ) {
        $this->eventFactsService = $eventFactsService;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:event')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $unibetId = '1227880_1';
        $this->eventFactsService->getEventFacts($unibetId);
    }
}
