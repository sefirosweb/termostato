<?php

namespace TermostatoBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Hum
 *
 * @ORM\Table(name="hum")
 * @ORM\Entity(repositoryClass="TermostatoBundle\Repository\HumRepository")
 */
class Hum
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
     * @ORM\Column(name="hum", type="decimal", precision=10, scale=2)
     */
    private $hum;


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



}
