<?php

namespace TermostatoBundle\Entity;

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

