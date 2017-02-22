<?php

namespace TermostatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Temp
 *
 * @ORM\Table(name="temp")
 * @ORM\Entity(repositoryClass="TermostatoBundle\Repository\TempRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Temp
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="temp", type="decimal", precision=10, scale=2)
     */
    private $temp;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Temp
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set temp
     *
     * @param string $temp
     *
     * @return Temp
     */
    public function setTemp($temp)
    {
        $this->temp = $temp;

        return $this;
    }

    /**
     * Get temp
     *
     * @return string
     */
    public function getTemp()
    {
        return $this->temp;
    }

    /**
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->date = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        //$this->date = new \DateTime("now");
    }
}
