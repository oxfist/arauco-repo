<?php

namespace Arauco\CSVBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Arauco\CSVBundle\Entity\Stock
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Arauco\CSVBundle\Entity\Repository\StockRepository")
 */
class Stock
{
    /**
     * @var string
     *
     * @ORM\Column(name="Centro", type="string" , length=255, nullable=true)
     */
    private $Centro;

    /**
     * @var string
     *
     * @ORM\Column(name="Almacen", type="string" , length=255, nullable=true)
     */
    private $Almacen;

    /**
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(name="Lote", type="string" , length=255, nullable=true)
     */
    private $Lote;

    /**
     * @var float
     *
     * @ORM\Column(name="M3", type="float" , nullable=true)
     */
    private $M3;

    /**
     * @var float
     *
     * @ORM\Column(name="Nro_Entrega", type="float" , nullable=true)
     */
    private $Nro_Entrega;

    /**
     * @var float
     *
     * @ORM\Column(name="Pos_Entrega", type="float" , nullable=true)
     */
    private $Pos_Entrega;

    /**
     * @var string
     *
     * @ORM\Column(name="Status", type="string", length=3 , nullable=true)
     */
    private $Status;

    /**
     * @var float
     *
     * @ORM\Column(name="Material", type="float" , nullable=true)
     */
    private $Material;

    /**
     * @var string
     *
     * @ORM\Column(name="Desc_Mat", type="string", length=255 , nullable=true)
     */
    private $Desc_Mat;

    /**
     * Set Centro
     *
     * @param string $centro
     * @return Stock
     */
    public function setCentro($centro)
    {
        $this->Centro = $centro;
    
        return $this;
    }

    /**
     * Get Centro
     *
     * @return string 
     */
    public function getCentro()
    {
        return $this->Centro;
    }

    /**
     * Set Almacen
     *
     * @param string $almacen
     * @return Stock
     */
    public function setAlmacen($almacen)
    {
        $this->Almacen = $almacen;
    
        return $this;
    }

    /**
     * Get Almacen
     *
     * @return string 
     */
    public function getAlmacen()
    {
        return $this->Almacen;
    }

    /**
     * Set M3
     *
     * @param float $m3
     * @return Stock
     */
    public function setM3($m3)
    {
        $this->M3 = $m3;
    
        return $this;
    }

    /**
     * Get M3
     *
     * @return float 
     */
    public function getM3()
    {
        return $this->M3;
    }

    /**
     * Set Nro_Entrega
     *
     * @param float $nroEntrega
     * @return Stock
     */
    public function setNroEntrega($nroEntrega)
    {
        $this->Nro_Entrega = $nroEntrega;
    
        return $this;
    }

    /**
     * Get Nro_Entrega
     *
     * @return float 
     */
    public function getNroEntrega()
    {
        return $this->Nro_Entrega;
    }

    /**
     * Set Pos_Entrega
     *
     * @param float $posEntrega
     * @return Stock
     */
    public function setPosEntrega($posEntrega)
    {
        $this->Pos_Entrega = $posEntrega;
    
        return $this;
    }

    /**
     * Get Pos_Entrega
     *
     * @return float 
     */
    public function getPosEntrega()
    {
        return $this->Pos_Entrega;
    }

    /**
     * Set Status
     *
     * @param string $status
     * @return Stock
     */
    public function setStatus($status)
    {
        $this->Status = $status;
    
        return $this;
    }

    /**
     * Get Status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     * Set Material
     *
     * @param float $material
     * @return Stock
     */
    public function setMaterial($material)
    {
        $this->Material = $material;
    
        return $this;
    }

    /**
     * Get Material
     *
     * @return float 
     */
    public function getMaterial()
    {
        return $this->Material;
    }

    /**
     * Set Desc_Mat
     *
     * @param string $descMat
     * @return Stock
     */
    public function setDescMat($descMat)
    {
        $this->Desc_Mat = $descMat;
    
        return $this;
    }

    /**
     * Get Desc_Mat
     *
     * @return string 
     */
    public function getDescMat()
    {
        return $this->Desc_Mat;
    }

    /**
     * Set Lote
     *
     * @param string $lote
     * @return Stock
     */
    public function setLote($lote)
    {
        $this->Lote = $lote;
    
        return $this;
    }

    /**
     * Get Lote
     *
     * @return string 
     */
    public function getLote()
    {
        return $this->Lote;
    }
}