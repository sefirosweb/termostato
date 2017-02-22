<?php

namespace TermostatoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Temp
 *
 * @ORM\Table(name="temp")
 * @ORM\Entity(repositoryClass="TermostatoBundle\Repository\TempRepository")
 */
class Temp
{
    /**
     * @ORM\OneToOne(targetEntity="Date", inversedBy="temp")
     * @ORM\JoinColumn(name="fk_date_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $date;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="temp", type="decimal", precision=10, scale=2)
     */
    private $temp;

    public function __construct()
    {
        $this->date = new ArrayCollection();
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
     * Set date
     *
     * @param \TermostatoBundle\Entity\Date $date
     *
     * @return Temp
     */
    public function setDate(\TermostatoBundle\Entity\Date $date = null)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \TermostatoBundle\Entity\Date
     */
    public function getDate()
    {
        return $this->date;
    }
}
