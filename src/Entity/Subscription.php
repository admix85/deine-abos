<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubscriptionRepository")
 */
class Subscription implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected string $name;

    /**
     * @ORM\Column(type="datetime")
     */
    protected \DateTime $startDate;

    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'startDate' => $this->startDate
        ];    }



    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }


    public function setStartDate(\DateTime $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

}