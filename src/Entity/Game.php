<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sport;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $homeTeamName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $awayTeamName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $unibetId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $competitionName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $competitionId;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isLive;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="integer")
     */
    private $homeScore;

    /**
     * @ORM\Column(type="integer")
     */
    private $awayScore;

    /**
     * @ORM\Column(type="integer")
     */
    private $chrono;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $period;

    public function __construct()
    {
        $this->created = new \DateTime();
        $this->isLive = false;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSport(): ?string
    {
        return $this->sport;
    }

    public function setSport(string $sport): self
    {
        $this->sport = $sport;

        return $this;
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

    public function getHomeTeamName(): ?string
    {
        return $this->homeTeamName;
    }

    public function setHomeTeamName(string $homeTeamName): self
    {
        $this->homeTeamName = $homeTeamName;

        return $this;
    }

    public function getAwayTeamName(): ?string
    {
        return $this->awayTeamName;
    }

    public function setAwayTeamName(string $awayTeamName): self
    {
        $this->awayTeamName = $awayTeamName;

        return $this;
    }

    public function getUnibetId(): ?string
    {
        return $this->unibetId;
    }

    public function setUnibetId(string $unibetId): self
    {
        $this->unibetId = $unibetId;

        return $this;
    }

    public function getCompetitionName(): ?string
    {
        return $this->competitionName;
    }

    public function setCompetitionName(?string $competitionName): self
    {
        $this->competitionName = $competitionName;

        return $this;
    }

    public function getCompetitionId(): ?int
    {
        return $this->competitionId;
    }

    public function setCompetitionId(?int $competitionId): self
    {
        $this->competitionId = $competitionId;

        return $this;
    }

    public function getIsLive(): ?bool
    {
        return $this->isLive;
    }

    public function setIsLive(bool $isLive): self
    {
        $this->isLive = $isLive;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

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

    public function getChrono(): int
    {
        return $this->chrono;
    }

    public function setChrono(int $chrono): self
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
