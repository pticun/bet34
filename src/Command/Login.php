<?php

namespace App\Command;

use App\Service\Unibet\HistoryService;
use App\Service\Unibet\LoginService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Login extends Command
{
    /**
     * @var LoginService
     */
    private $login;

    /**
     * @var HistoryService
     */
    private $historyService;

    public function __construct(
        LoginService $login,
        HistoryService $historyService
    ) {
        $this->login = $login;
        $this->historyService = $historyService;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:login')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->historyService->getHistory();
    }
}
