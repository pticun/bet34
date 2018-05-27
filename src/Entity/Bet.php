<?php

namespace App\Entity;

use App\Repository\BetRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BetRepository::class)
 * @ORM\HasLifecycleCallbacks
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
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $marketType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $marketId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $selectionId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $selectionName;

    /**
     * @ORM\Column(type="float")
     */
    private $rank;

    /**
     * @ORM\Column(type="integer")
     */
    private $priceUp;

    /**
     * @ORM\Column(type="integer")
     */
    private $priceDown;

    /**
     * @ORM\Column(type="integer")
     */
    private $homeScore;

    /**
     * @ORM\Column(type="integer")
     */
    private $awayScore;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $homePoint;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $awayPoint;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $position;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isWin;

    /**
     * @ORM\ManyToOne(targetEntity=Set::class)
     * @ORM\JoinColumn(nullable=false, name="set_id")
     */
    private $set;

    /**
     * @var bool
     */
    private $isTradable;

    public function __construct()
    {
        $this->created = new \DateTime();
        $this->isTradable = false;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->updated = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }

    public function setUpdated(\DateTime $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    public function getMarketType(): string
    {
        return $this->marketType;
    }

    public function setMarketType(string $marketType): self
    {
        $this->marketType = $marketType;

        return $this;
    }

    public function getMarketId(): string
    {
        return $this->marketId;
    }

    public function setMarketId(string $marketId): self
    {
        $this->marketId = $marketId;

        return $this;
    }

    public function getSelectionId(): string
    {
        return $this->selectionId;
    }

    public function setSelectionId(string $selectionId): self
    {
        $this->selectionId = $selectionId;

        return $this;
    }

    public function getSelectionName(): string
    {
        return $this->selectionName;
    }

    public function setSelectionName(string $selectionName): self
    {
        $this->selectionName = $selectionName;

        return $this;
    }

    public function getRank(): float
    {
        return $this->rank;
    }

    public function setRank(float $rank): self
    {
        $this->rank = $rank;

        return $this;
    }

    public function getPriceUp(): int
    {
        return $this->priceUp;
    }

    public function setPriceUp(int $priceUp): self
    {
        $this->priceUp = $priceUp;

        return $this;
    }

    public function getPriceDown(): int
    {
        return $this->priceDown;
    }

    public function setPriceDown(int $priceDown): self
    {
        $this->priceDown = $priceDown;

        return $this;
    }

    public function getHomeScore(): int
    {
        return $this->homeScore;
    }

    public function setHomeScore(int $homeScore): self
    {
        $this->homeScore = $homeScore;

        return $this;
    }

    public function getAwayScore(): int
    {
        return $this->awayScore;
    }

    public function setAwayScore(int $awayScore): self
    {
        $this->awayScore = $awayScore;

        return $this;
    }

    public function getHomePoint(): string
    {
        return $this->homePoint;
    }

    public function setHomePoint(string $homePoint): self
    {
        $this->homePoint = $homePoint;

        return $this;
    }

    public function getAwayPoint(): string
    {
        return $this->awayPoint;
    }

    public function setAwayPoint(string $awayPoint): self
    {
        $this->awayPoint = $awayPoint;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(?string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getSet(): Set
    {
        return $this->set;
    }

    public function setSet(Set $set): self
    {
        $this->set = $set;

        return $this;
    }

    public function isTradable(): bool
    {
        return $this->isTradable;
    }

    public function setTradable(bool $isTradable): self
    {
        $this->isTradable = $isTradable;

        return $this;
    }

    public function isWin(): bool
    {
        return $this->isWin;
    }

    public function setWin(bool $isWin): self
    {
        $this->isWin = $isWin;

        return $this;
    }
}
