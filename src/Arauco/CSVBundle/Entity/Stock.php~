<?php

namespace Arauco\CSVBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stock
 *
 * @ORM\Table(name="Stock")
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
     * @var string
     *
     * @ORM\Id
     * @ORM\Column(name="Lote", type="string" , length=255, nullable=true)
     */
    private $Lote;

    /**
     * @var float
     *
     * @ORM\Column(name="VolLot", type="float" , nullable=true)
     */
    private $VolLot;

    /**
     * @var float
     *
     * @ORM\Column(name="VolLotTran", type="float" , nullable=true)
     */
    private $VolLotTran;

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
     * @var string
     *
     * @ORM\Column(name="STO_STATUS_ASI_ETA", type="string", length=1 , nullable=true)
     */
    private $STO_STATUS_ASI_ETA;

    /**
     * @var string
     *
     * @ORM\Column(name="STO_DOCENTREGA_ASI_ETA", type="string", length=30, nullable=true)
     */
    private $STO_DOCENTREGA_ASI_ETA;

    /**
     * @var string
     *
     * @ORM\Column(name="STO_POSPEDIDO_ASI_ETA", type="string", length=30, nullable=true)
     */
    private $STO_POSPEDIDO_ASI_ETA;

    /**
     * @var string
     *
     * @ORM\Column(name="STO_STATUS_ASI_FPE", type="string", length=1, nullable=true)
     */
    private $STO_STATUS_ASI_FPE;

    /**
     * @var string
     *
     * @ORM\Column(name="STO_DOCENTREGA_ASI_FPE", type="string", length=30, nullable=true)
     */
    private $STO_DOCENTREGA_ASI_FPE;

    /**
     * @var string
     *
     * @ORM\Column(name="STO_POSPEDIDO_ASI_FPE", type="string", length=30, nullable=true)
     */
    private $STO_POSPEDIDO_ASI_FPE;



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

    /**
     * Set VolLot
     *
     * @param float $volLot
     * @return Stock
     */
    public function setVolLot($volLot)
    {
        $this->VolLot = $volLot;
    
        return $this;
    }

    /**
     * Get VolLot
     *
     * @return float 
     */
    public function getVolLot()
    {
        return $this->VolLot;
    }

    /**
     * Set VolLotTran
     *
     * @param float $volLotTran
     * @return Stock
     */
    public function setVolLotTran($volLotTran)
    {
        $this->VolLotTran = $volLotTran;
    
        return $this;
    }

    /**
     * Get VolLotTran
     *
     * @return float 
     */
    public function getVolLotTran()
    {
        return $this->VolLotTran;
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
     * Set STO_STATUS_ASI_ETA
     *
     * @param string $sTOSTATUSASIETA
     * @return Stock
     */
    public function setSTOSTATUSASIETA($sTOSTATUSASIETA)
    {
        $this->STO_STATUS_ASI_ETA = $sTOSTATUSASIETA;
    
        return $this;
    }

    /**
     * Get STO_STATUS_ASI_ETA
     *
     * @return string 
     */
    public function getSTOSTATUSASIETA()
    {
        return $this->STO_STATUS_ASI_ETA;
    }

    /**
     * Set STO_DOCENTREGA_ASI_ETA
     *
     * @param string $sTODOCENTREGAASIETA
     * @return Stock
     */
    public function setSTODOCENTREGAASIETA($sTODOCENTREGAASIETA)
    {
        $this->STO_DOCENTREGA_ASI_ETA = $sTODOCENTREGAASIETA;
    
        return $this;
    }

    /**
     * Get STO_DOCENTREGA_ASI_ETA
     *
     * @return string 
     */
    public function getSTODOCENTREGAASIETA()
    {
        return $this->STO_DOCENTREGA_ASI_ETA;
    }

    /**
     * Set STO_POSPEDIDO_ASI_ETA
     *
     * @param string $sTOPOSPEDIDOASIETA
     * @return Stock
     */
    public function setSTOPOSPEDIDOASIETA($sTOPOSPEDIDOASIETA)
    {
        $this->STO_POSPEDIDO_ASI_ETA = $sTOPOSPEDIDOASIETA;
    
        return $this;
    }

    /**
     * Get STO_POSPEDIDO_ASI_ETA
     *
     * @return string 
     */
    public function getSTOPOSPEDIDOASIETA()
    {
        return $this->STO_POSPEDIDO_ASI_ETA;
    }

    /**
     * Set STO_STATUS_ASI_FPE
     *
     * @param string $sTOSTATUSASIFPE
     * @return Stock
     */
    public function setSTOSTATUSASIFPE($sTOSTATUSASIFPE)
    {
        $this->STO_STATUS_ASI_FPE = $sTOSTATUSASIFPE;
    
        return $this;
    }

    /**
     * Get STO_STATUS_ASI_FPE
     *
     * @return string 
     */
    public function getSTOSTATUSASIFPE()
    {
        return $this->STO_STATUS_ASI_FPE;
    }

    /**
     * Set STO_DOCENTREGA_ASI_FPE
     *
     * @param string $sTODOCENTREGAASIFPE
     * @return Stock
     */
    public function setSTODOCENTREGAASIFPE($sTODOCENTREGAASIFPE)
    {
        $this->STO_DOCENTREGA_ASI_FPE = $sTODOCENTREGAASIFPE;
    
        return $this;
    }

    /**
     * Get STO_DOCENTREGA_ASI_FPE
     *
     * @return string 
     */
    public function getSTODOCENTREGAASIFPE()
    {
        return $this->STO_DOCENTREGA_ASI_FPE;
    }

    /**
     * Set STO_POSPEDIDO_ASI_FPE
     *
     * @param string $sTOPOSPEDIDOASIFPE
     * @return Stock
     */
    public function setSTOPOSPEDIDOASIFPE($sTOPOSPEDIDOASIFPE)
    {
        $this->STO_POSPEDIDO_ASI_FPE = $sTOPOSPEDIDOASIFPE;
    
        return $this;
    }

    /**
     * Get STO_POSPEDIDO_ASI_FPE
     *
     * @return string 
     */
    public function getSTOPOSPEDIDOASIFPE()
    {
        return $this->STO_POSPEDIDO_ASI_FPE;
    }
}