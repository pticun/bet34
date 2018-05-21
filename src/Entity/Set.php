<?php

namespace App\Entity;

use App\Repository\SetRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SetRepository::class)
 * @ORM\Table(name="Period")
 * @ORM\HasLifecycleCallbacks
 */
class Set
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
     * @ORM\ManyToOne(targetEntity=Tennis::class)
     * @ORM\JoinColumn(nullable=false, name="tennis_id")
     */
    private $match;

    /**
     * @ORM\Column(type="integer", name="period")
     */
    private $order;

    public function __construct()
    {
        $this->created = new \DateTime();
        $this->homeScore = 0;
        $this->awayScore = 0;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->updated = new \DateTime();
    }

    public function getId(): int
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

    public function getMatch(): Tennis
    {
        return $this->match;
    }

    public function setMatch(Tennis $match): self
    {
        $this->match = $match;

        return $this;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function setOrder(int $order): self
    {
        $this->order = $order;

        return $this;
    }
}
