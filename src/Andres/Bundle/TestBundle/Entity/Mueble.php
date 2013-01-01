<?php

namespace Andres\Bundle\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mueble
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Mueble
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=10)
     */
    private $nombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="largo", type="smallint")
     */
    private $largo;

    /**
     * @var integer
     *
     * @ORM\Column(name="ancho", type="smallint")
     */
    private $ancho;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Mueble
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set largo
     *
     * @param integer $largo
     * @return Mueble
     */
    public function setLargo($largo)
    {
        $this->largo = $largo;
    
        return $this;
    }

    /**
     * Get largo
     *
     * @return integer 
     */
    public function getLargo()
    {
        return $this->largo;
    }

    /**
     * Set ancho
     *
     * @param integer $ancho
     * @return Mueble
     */
    public function setAncho($ancho)
    {
        $this->ancho = $ancho;
    
        return $this;
    }

    /**
     * Get ancho
     *
     * @return integer 
     */
    public function getAncho()
    {
        return $this->ancho;
    }
}
