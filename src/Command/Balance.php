<?php

namespace App\Command;

use App\Service\BalanceService;
use DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Balance extends Command
{
    /**
     * @var BalanceService
     */
    private $balanceService;

    public function __construct(
        BalanceService $balanceService
    ) {
        $this->balanceService = $balanceService;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:balance')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $day = $this->getDay();

        $nbBet = $this->balanceService->getNbBet($day);
        $nbWonBet = $this->balanceService->getNbWonBet($day);

        // Nombre de paris joués
        $output->writeln(sprintf('Nombre de paris joués : %d', $nbBet));

        if (0 === $nbBet) {
            return;
        }

        // Nombre de paris gagnés
        $percentageWonBet = ($nbWonBet / $nbBet) * 100;
        $output->writeln(sprintf('Nombre de paris gagnés : %d (%d %%)', $nbWonBet, $percentageWonBet));

        // Balance
        $output->writeln(sprintf('Balance : %f', $this->balanceService->getBalance($day)));
    }

    private function getDay(): DateTime
    {
        return new DateTime();
    }
}
