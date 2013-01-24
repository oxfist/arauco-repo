<?php

namespace Arauco\CSVBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pedidos
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Arauco\CSVBundle\Entity\Repository\PedidosRepository")
 */
class Pedidos
{
    /**
     * @var string
     *
     * @ORM\Column(name="Nave", type="string", length=255, nullable=true)
     */
    private $Nave;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Eta", type="date" , nullable=true)
     */
    private $Eta;

    /**
     * @var float
     *
     * @ORM\Id
     * @ORM\Column(name="DocEntrega", type="float" , nullable=true)
     */
    private $DocEntrega;

    /**
     * @var float
     *
     * @ORM\Id
     * @ORM\Column(name="PosPedido", type="float", nullable=true)
     */
    private $PosPedido;

    /**
     * @var float
     *
     * @ORM\Column(name="VolPedido", type="float", nullable=true)
     */
    private $VolPedido;

    /**
     * @var string
     *
     * @ORM\Column(name="UMV", type="string", length=2, nullable=true)
     */
    private $UMV;

    /**
     * @var float
     *
     * @ORM\Column(name="Material", type="float", nullable=true)
     */
    private $Material;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FPE", type="date", nullable=true)
     */
    private $FPE;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FPAN", type="date", nullable=true)
     */
    private $FPAN;

    /**
     * @var string
     *
     * @ORM\Column(name="StatusMovimientodeMcia", type="string", length=255, nullable=true)
     */
    private $StatusMovimientodeMcia;

    /**
     * @var string
     *
     * @ORM\Column(name="StatusComplete", type="string", length=2, nullable=true)
     */
    private $StatusComplete;

    /**
     * @var string
     *
     * @ORM\Column(name="DescripcionMaterial", type="string", length=255, nullable=true)
     */
    private $DescripcionMaterial;

    /**
     * @var boolean
     *
     * @ORM\Column(name="PED_COMPLETABLE_ETA", type="boolean", nullable=true)
     */
    private $PED_COMPLETABLE_ETA;

    /**
     * @var boolean
     *
     * @ORM\Column(name="PED_COMPLETABLE_FPE", type="boolean", nullable=true)
     */
    private $PED_COMPLETABLE_FPE;


    /**
     * Set Nave
     *
     * @param string $nave
     * @return Pedidos
     */
    public function setNave($nave)
    {
        $this->Nave = $nave;
    
        return $this;
    }

    /**
     * Get Nave
     *
     * @return string 
     */
    public function getNave()
    {
        return $this->Nave;
    }

    /**
     * Set Eta
     *
     * @param \DateTime $eta
     * @return Pedidos
     */
    public function setEta($eta)
    {
        $this->Eta = $eta;
    
        return $this;
    }

    /**
     * Get Eta
     *
     * @return \DateTime 
     */
    public function getEta()
    {
        return $this->Eta;
    }

    /**
     * Set DocEntrega
     *
     * @param float $docEntrega
     * @return Pedidos
     */
    public function setDocEntrega($docEntrega)
    {
        $this->DocEntrega = $docEntrega;
    
        return $this;
    }

    /**
     * Get DocEntrega
     *
     * @return float 
     */
    public function getDocEntrega()
    {
        return $this->DocEntrega;
    }

    /**
     * Set PosPedido
     *
     * @param float $posPedido
     * @return Pedidos
     */
    public function setPosPedido($posPedido)
    {
        $this->PosPedido = $posPedido;
    
        return $this;
    }

    /**
     * Get PosPedido
     *
     * @return float 
     */
    public function getPosPedido()
    {
        return $this->PosPedido;
    }

    /**
     * Set VolPedido
     *
     * @param float $volPedido
     * @return Pedidos
     */
    public function setVolPedido($volPedido)
    {
        $this->VolPedido = $volPedido;
    
        return $this;
    }

    /**
     * Get VolPedido
     *
     * @return float 
     */
    public function getVolPedido()
    {
        return $this->VolPedido;
    }

    /**
     * Set UMV
     *
     * @param string $uMV
     * @return Pedidos
     */
    public function setUMV($uMV)
    {
        $this->UMV = $uMV;
    
        return $this;
    }

    /**
     * Get UMV
     *
     * @return string 
     */
    public function getUMV()
    {
        return $this->UMV;
    }

    /**
     * Set Material
     *
     * @param float $material
     * @return Pedidos
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
     * Set FPE
     *
     * @param \DateTime $fPE
     * @return Pedidos
     */
    public function setFPE($fPE)
    {
        $this->FPE = $fPE;
    
        return $this;
    }

    /**
     * Get FPE
     *
     * @return \DateTime 
     */
    public function getFPE()
    {
        return $this->FPE;
    }

    /**
     * Set FPAN
     *
     * @param \DateTime $fPAN
     * @return Pedidos
     */
    public function setFPAN($fPAN)
    {
        $this->FPAN = $fPAN;
    
        return $this;
    }

    /**
     * Get FPAN
     *
     * @return \DateTime 
     */
    public function getFPAN()
    {
        return $this->FPAN;
    }

    /**
     * Set StatusMovimientodeMcia
     *
     * @param string $statusMovimientodeMcia
     * @return Pedidos
     */
    public function setStatusMovimientodeMcia($statusMovimientodeMcia)
    {
        $this->StatusMovimientodeMcia = $statusMovimientodeMcia;
    
        return $this;
    }

    /**
     * Get StatusMovimientodeMcia
     *
     * @return string 
     */
    public function getStatusMovimientodeMcia()
    {
        return $this->StatusMovimientodeMcia;
    }

    /**
     * Set DescripcionMaterial
     *
     * @param string $descripcionMaterial
     * @return Pedidos
     */
    public function setDescripcionMaterial($descripcionMaterial)
    {
        $this->DescripcionMaterial = $descripcionMaterial;
    
        return $this;
    }

    /**
     * Get DescripcionMaterial
     *
     * @return string 
     */
    public function getDescripcionMaterial()
    {
        return $this->DescripcionMaterial;
    }

    /**
     * Set StatusComplete
     *
     * @param string $statusComplete
     * @return Pedidos
     */
    public function setStatusComplete($statusComplete)
    {
        $this->StatusComplete = $statusComplete;
    
        return $this;
    }

    /**
     * Get StatusComplete
     *
     * @return string 
     */
    public function getStatusComplete()
    {
        return $this->StatusComplete;
    }

    /**
     * Set PED_COMPLETABLE_ETA
     *
     * @param boolean $pEDCOMPLETABLEETA
     * @return Pedidos
     */
    public function setPEDCOMPLETABLEETA($pEDCOMPLETABLEETA)
    {
        $this->PED_COMPLETABLE_ETA = $pEDCOMPLETABLEETA;
    
        return $this;
    }

    /**
     * Get PED_COMPLETABLE_ETA
     *
     * @return boolean 
     */
    public function getPEDCOMPLETABLEETA()
    {
        return $this->PED_COMPLETABLE_ETA;
    }

    /**
     * Set PED_COMPLETABLE_FPE
     *
     * @param boolean $pEDCOMPLETABLEFPE
     * @return Pedidos
     */
    public function setPEDCOMPLETABLEFPE($pEDCOMPLETABLEFPE)
    {
        $this->PED_COMPLETABLE_FPE = $pEDCOMPLETABLEFPE;
    
        return $this;
    }

    /**
     * Get PED_COMPLETABLE_FPE
     *
     * @return boolean 
     */
    public function getPEDCOMPLETABLEFPE()
    {
        return $this->PED_COMPLETABLE_FPE;
    }
}