<?php

namespace App\Entity;

use App\Repository\TennisRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TennisRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Tennis
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $competitionName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $unibetId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $homeName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $homeShortName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $awayName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $awayShortName;

    public function __construct()
    {
        $this->created = new \DateTime();
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCompetitionName(): string
    {
        return $this->competitionName;
    }

    public function setCompetitionName(string $competitionName): self
    {
        $this->competitionName = $competitionName;

        return $this;
    }

    public function getUnibetId(): string
    {
        return $this->unibetId;
    }

    public function setUnibetId(string $unibetId): self
    {
        $this->unibetId = $unibetId;

        return $this;
    }

    public function getHomeName(): string
    {
        return $this->homeName;
    }

    public function setHomeName(string $homeName): self
    {
        $this->homeName = $homeName;

        return $this;
    }

    public function getHomeShortName(): string
    {
        return $this->homeShortName;
    }

    public function setHomeShortName(string $homeShortName): self
    {
        $this->homeShortName = $homeShortName;

        return $this;
    }

    public function getAwayName(): string
    {
        return $this->awayName;
    }

    public function setAwayName(string $awayName): self
    {
        $this->awayName = $awayName;

        return $this;
    }

    public function getAwayShortName(): string
    {
        return $this->awayShortName;
    }

    public function setAwayShortName(string $awayShortName): self
    {
        $this->awayShortName = $awayShortName;

        return $this;
    }
}
