<?php

namespace TermostatoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Date
 *
 * @ORM\Table(name="date")
 * @ORM\Entity(repositoryClass="TermostatoBundle\Repository\DateRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Date
{
    /**
     * @ORM\OneToOne(targetEntity="Hum", mappedBy="date")
     */
    private $hum;

    /**
     * @ORM\OneToOne(targetEntity="Temp", mappedBy="date")
     */
    private $temp;

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
     * @ORM\Column(name="datetime", type="datetime")
     */
    private $datetime;


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
     * Set datetime
     *
     * @param \DateTime $datetime
     *
     * @return Date
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }


    /**
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        if ($this->datetime == null) {
            $this->datetime = new \DateTime("now");
        }
    }

    /**
     * Gets triggered every time on update
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        //$this->date = new \DateTime("now");
    }

    /**
     * Set hum
     *
     * @param \TermostatoBundle\Entity\Temp $hum
     *
     * @return Date
     */
    public function setHum(\TermostatoBundle\Entity\Temp $hum = null)
    {
        $this->hum = $hum;

        return $this;
    }

    /**
     * Get hum
     *
     * @return \TermostatoBundle\Entity\Temp
     */
    public function getHum()
    {
        return $this->hum;
    }

    /**
     * Set temp
     *
     * @param \TermostatoBundle\Entity\Temp $temp
     *
     * @return Date
     */
    public function setTemp(\TermostatoBundle\Entity\Temp $temp = null)
    {
        $this->temp = $temp;

        return $this;
    }

    /**
     * Get temp
     *
     * @return \TermostatoBundle\Entity\Temp
     */
    public function getTemp()
    {
        return $this->temp;
    }
}
