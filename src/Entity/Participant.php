<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * @ORM\Entity()
 */
class Participant
{

    /**
     * @ORM\Id()
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @var string
     * @Column(type="string", name="name")
     */
    private $name;

    /**
     * @var int
     * @Column(name="age", type="integer")
     */
    private $age;

    /**
     * @var \DateTime
     * @Column(name="start_time", type="datetime", nullable=true)
     */
    private $startTime;

    /**
     * @var \DateTime
     * @Column(name="end_time", type="datetime", nullable=true)
     */
    private $endTime;

    /**
     * @var string
     * @Column(type="string", length=2, name="`group`")
     */
    private $group;

    /**
     * @var string
     * @Column(type="string", length=20)
     */
    private $ip;


    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getStartTime(): ?\DateTime
    {
        return $this->startTime;
    }

    /**
     * @param \DateTime $startTime
     */
    public function setStartTime(\DateTime $startTime): void
    {
        $this->startTime = $startTime;
    }

    public function getEndTime(): ?\DateTime
    {
        return $this->endTime;
    }

    /**
     * @param \DateTime $endTime
     */
    public function setEndTime(\DateTime $endTime): void
    {
        $this->endTime = $endTime;
    }

    /**
     * @param int $age
     */
    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp(string $ip): void
    {
        $this->ip = $ip;
    }

    public function getGroup(): string
    {
        return $this->group;
    }

    /**
     * @param string $group
     */
    public function setGroup(string $group): void
    {
        $this->group = $group;
    }


    /**
     * @param string $name
     */
    public function setName(
        string $name
    ): void {
        $this->name = $name;
    }

    public function getDuration():int
    {
        return $this->endTime->diff($this->startTime)->s;
    }
}
