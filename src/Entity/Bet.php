<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BetRepository")
 */
class Bet
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $marketName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $homeSelectionName;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $homeRate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $awaySelectionName;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $awayRate;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $drawRate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Game")
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;

    /**
     * @ORM\Column(type="integer")
     */
    private $homeScore;

    /**
     * @ORM\Column(type="integer")
     */
    private $awayScore;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $chrono;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $period;


    public function __construct()
    {
        $this->created = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getMarketName(): ?string
    {
        return $this->marketName;
    }

    public function setMarketName(string $marketName): self
    {
        $this->marketName = $marketName;

        return $this;
    }



    public function getHomeSelectionName(): ?string
    {
        return $this->homeSelectionName;
    }

    public function setHomeSelectionName(string $homeSelectionName): self
    {
        $this->homeSelectionName = $homeSelectionName;

        return $this;
    }

    public function getHomeRate(): ?float
    {
        return $this->homeRate;
    }

    public function setHomeRate(float $homeRate): self
    {
        $this->homeRate = $homeRate;

        return $this;
    }




    public function getAwaySelectionName(): ?string
    {
        return $this->awaySelectionName;
    }

    public function setAwaySelectionName(string $awaySelectionName): self
    {
        $this->awaySelectionName = $awaySelectionName;

        return $this;
    }

    public function getAwayRate(): ?float
    {
        return $this->awayRate;
    }

    public function setAwayRate(float $awayRate): self
    {
        $this->awayRate = $awayRate;

        return $this;
    }


    public function getDrawRate(): ?float
    {
        return $this->drawRate;
    }

    public function setDrawRate(float $drawRate): self
    {
        $this->drawRate = $drawRate;

        return $this;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    public function getHomeScore(): ?int
    {
        return $this->homeScore;
    }

    public function setHomeScore(int $homeScore): self
    {
        $this->homeScore = $homeScore;

        return $this;
    }

    public function getAwayScore(): ?int
    {
        return $this->awayScore;
    }

    public function setAwayScore(int $awayScore): self
    {
        $this->awayScore = $awayScore;

        return $this;
    }

    public function getChrono(): string
    {
        return $this->chrono;
    }

    public function setChrono(string $chrono): self
    {
        $this->chrono = $chrono;

        return $this;
    }

    public function getPeriod(): string
    {
        return $this->period;
    }

    public function setPeriod(string $period): self
    {
        $this->period = $period;

        return $this;
    }
}
