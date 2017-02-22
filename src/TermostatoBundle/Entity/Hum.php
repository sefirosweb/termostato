<?php

namespace TermostatoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Hum
 *
 * @ORM\Table(name="hum")
 * @ORM\Entity(repositoryClass="TermostatoBundle\Repository\HumRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Hum
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
     * @ORM\Column(name="hum", type="decimal", precision=10, scale=2)
     */
    private $hum;


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
     * @return Hum
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
     * Set hum
     *
     * @param string $hum
     *
     * @return Hum
     */
    public function setHum($hum)
    {
        $this->hum = $hum;

        return $this;
    }

    /**
     * Get hum
     *
     * @return string
     */
    public function getHum()
    {
        return $this->hum;
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

