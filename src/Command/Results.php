<?php

namespace App\Command;

use App\Entity\Bet;
use App\Repository\BetRepository;
use App\Service\BetResultService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Results extends Command
{
    /**
     * @var BetRepository
     */
    private $betRepository;

    /**
     * @var BetResultService
     */
    private $betResultService;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(
        BetRepository $betRepository,
        BetResultService $betResultService,
        EntityManagerInterface $em
    ) {
        $this->betRepository = $betRepository;
        $this->betResultService = $betResultService;
        $this->em = $em;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:results')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $bets = $this->betRepository->findBy(['isWin' => null]);
        foreach ($bets as $bet) {
            $this->setResult($bet);
            sleep(1);
        }
        $this->em->flush();
    }

    private function setResult(Bet $bet): void
    {
        $isWin = $this->betResultService->getResultForBet($bet);
        $bet->setWin($isWin);
    }
}
