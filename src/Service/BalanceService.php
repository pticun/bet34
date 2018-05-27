<?php

namespace App\Service;

use App\Entity\Bet;
use App\Repository\BetRepository;
use DateTime;

class BalanceService
{
    /**
     * @var BetRepository
     */
    private $betRepository;

    public function __construct(
        BetRepository $betRepository
    ) {
        $this->betRepository = $betRepository;
    }

    public function getNbBet(DateTime $day): int
    {
        $start = (clone $day)->modify('midnight');
        $end = (clone $start)->modify('+ 1 day');

        return
            $this->betRepository->createQueryBuilder('bet')
            ->select('COUNT(bet) AS NB')
            ->andWhere('bet.isWin IS NOT NULL')
            ->andWhere('bet.created BETWEEN :start and :end')
            ->setParameters(['start' => $start, 'end' => $end])
            ->getQuery()
            ->getSingleResult()['NB']
        ;
    }

    public function getNbWonBet(DateTime $day): int
    {
        $start = (clone $day)->modify('midnight');
        $end = (clone $start)->modify('+ 1 day');

        return
            $this->betRepository->createQueryBuilder('bet')
            ->select('COUNT(bet) AS NB')
            ->andWhere('bet.isWin = :isWin')
            ->andWhere('bet.created BETWEEN :start and :end')
            ->setParameters(['isWin' => true, 'start' => $start, 'end' => $end])
            ->getQuery()
            ->getSingleResult()['NB']
        ;
    }
}
