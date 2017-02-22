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
     * @ORM\OneToOne(targetEntity="Temp", mappedBy="date")
     * @ORM\OneToOne(targetEntity="Hum", mappedBy="date")
     */
    protected $temp;

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

    public function __construct()
    {
        $this->temp = new ArrayCollection();
    }

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
     * Add temp
     *
     * @param \TermostatoBundle\Entity\Temp $temp
     *
     * @return Date
     */
    public function addTemp(\TermostatoBundle\Entity\Temp $temp)
    {
        $this->temp[] = $temp;

        return $this;
    }

    /**
     * Remove temp
     *
     * @param \TermostatoBundle\Entity\Temp $temp
     */
    public function removeTemp(\TermostatoBundle\Entity\Temp $temp)
    {
        $this->temp->removeElement($temp);
    }

    /**
     * Get temp
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTemp()
    {
        return $this->temp;
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
}
