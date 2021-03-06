<?php

namespace Arauco\CSVBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pedidos
 *
 * @ORM\Table(name="Pedidos")
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
     * @var smallint
     *
     * @ORM\Column(name="PED_UNIDADES_SOLICITADAS", type="smallint", nullable=true)
     */
    private $unidadesSolicitadas;

    /**
     * @var smallint
     *
     * @ORM\Column(name="PED_UNIDADES_ASIGNADAS", type="smallint", nullable=true)
     */
    private $unidadesAsignadas;

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
     * @ORM\Column(name="StatusComplete", type="string", length=4, nullable=true)
     */
    private $StatusComplete;

    /**
     * @var string
     *
     * @ORM\Column(name="DescripcionMaterial", type="string", length=255, nullable=true)
     */
    private $DescripcionMaterial;

    /**
     * @var integer unsigned
     *
     * @ORM\Id
     * @ORM\Column(name="PosOrdenFac", type="integer", nullable=false)
     */
    private $PosOrdenFac;

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
     * @var integer unsigned
     *
     * @ORM\Column(name="OrgVenta", type="integer", nullable=false)
     */
    private $OrgVenta;

    /**
     * @var string
     *
     * @ORM\Column(name="EntComp", type="string", length=2, nullable=false)
     */
    private $EntComp;

    /**
     * @var string
     *
     * @ORM\Column(name="CodCliente", type="string", length=10, nullable=false)
     */
    private $CodCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="NomCliente", type="string", length=64, nullable=false)
     */
    private $NomCliente;

    /**
     * @var string
     *
     * @ORM\Column(name="Destino", type="string", length=64, nullable=false)
     */
    private $Destino;

    /**
     * @var string
     *
     * @ORM\Column(name="PaisDestino", type="string", length=32, nullable=false)
     */
    private $PaisDestino;

    /**
     * @var string
     *
     * @ORM\Column(name="MT", type="string", length=3, nullable=false)
     */
    private $MT;

    /**
     * @var string
     *
     * @ORM\Column(name="ClaseMaterial", type="string", length=32, nullable=false)
     */
    private $ClaseMaterial;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FecEnt", type="date" , nullable=true)
     */
    private $FecEnt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="FPD", type="date" , nullable=true)
     */
    private $FPD;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="RoundVentas", type="date" , nullable=true)
     */
    private $RoundVentas;


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
     * Set unidadesSolicitadas
     *
     * @param integer $unidadesSolicitadas
     * @return Pedidos
     */
    public function setUnidadesSolicitadas($unidadesSolicitadas)
    {
        $this->unidadesSolicitadas = $unidadesSolicitadas;
    
        return $this;
    }

    /**
     * Get unidadesSolicitadas
     *
     * @return integer 
     */
    public function getUnidadesSolicitadas()
    {
        return $this->unidadesSolicitadas;
    }

    /**
     * Set unidadesAsignadas
     *
     * @param integer $unidadesAsignadas
     * @return Pedidos
     */
    public function setUnidadesAsignadas($unidadesAsignadas)
    {
        $this->unidadesAsignadas = $unidadesAsignadas;
    
        return $this;
    }

    /**
     * Get unidadesAsignadas
     *
     * @return integer 
     */
    public function getUnidadesAsignadas()
    {
        return $this->unidadesAsignadas;
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

    /**
     * Set PosOrdenFac
     *
     * @param integer $posOrdenFac
     * @return Pedidos
     */
    public function setPosOrdenFac($posOrdenFac)
    {
        $this->PosOrdenFac = $posOrdenFac;
    
        return $this;
    }

    /**
     * Get PosOrdenFac
     *
     * @return integer 
     */
    public function getPosOrdenFac()
    {
        return $this->PosOrdenFac;
    }

    /**
     * Set OrgVenta
     *
     * @param integer $orgVenta
     * @return Pedidos
     */
    public function setOrgVenta($orgVenta)
    {
        $this->OrgVenta = $orgVenta;
    
        return $this;
    }

    /**
     * Get OrgVenta
     *
     * @return integer 
     */
    public function getOrgVenta()
    {
        return $this->OrgVenta;
    }

    /**
     * Set EntComp
     *
     * @param string $entComp
     * @return Pedidos
     */
    public function setEntComp($entComp)
    {
        $this->EntComp = $entComp;
    
        return $this;
    }

    /**
     * Get EntComp
     *
     * @return string 
     */
    public function getEntComp()
    {
        return $this->EntComp;
    }

    /**
     * Set CodCliente
     *
     * @param string $codCliente
     * @return Pedidos
     */
    public function setCodCliente($codCliente)
    {
        $this->CodCliente = $codCliente;
    
        return $this;
    }

    /**
     * Get CodCliente
     *
     * @return string 
     */
    public function getCodCliente()
    {
        return $this->CodCliente;
    }

    /**
     * Set NomCliente
     *
     * @param string $nomCliente
     * @return Pedidos
     */
    public function setNomCliente($nomCliente)
    {
        $this->NomCliente = $nomCliente;
    
        return $this;
    }

    /**
     * Get NomCliente
     *
     * @return string 
     */
    public function getNomCliente()
    {
        return $this->NomCliente;
    }

    /**
     * Set Destino
     *
     * @param string $destino
     * @return Pedidos
     */
    public function setDestino($destino)
    {
        $this->Destino = $destino;
    
        return $this;
    }

    /**
     * Get Destino
     *
     * @return string 
     */
    public function getDestino()
    {
        return $this->Destino;
    }

    /**
     * Set PaisDestino
     *
     * @param string $paisDestino
     * @return Pedidos
     */
    public function setPaisDestino($paisDestino)
    {
        $this->PaisDestino = $paisDestino;
    
        return $this;
    }

    /**
     * Get PaisDestino
     *
     * @return string 
     */
    public function getPaisDestino()
    {
        return $this->PaisDestino;
    }

    /**
     * Set MT
     *
     * @param string $mT
     * @return Pedidos
     */
    public function setMT($mT)
    {
        $this->MT = $mT;
    
        return $this;
    }

    /**
     * Get MT
     *
     * @return string 
     */
    public function getMT()
    {
        return $this->MT;
    }

    /**
     * Set ClaseMaterial
     *
     * @param string $claseMaterial
     * @return Pedidos
     */
    public function setClaseMaterial($claseMaterial)
    {
        $this->ClaseMaterial = $claseMaterial;
    
        return $this;
    }

    /**
     * Get ClaseMaterial
     *
     * @return string 
     */
    public function getClaseMaterial()
    {
        return $this->ClaseMaterial;
    }

    /**
     * Set FecEnt
     *
     * @param \DateTime $fecDis
     * @return Pedidos
     */
    public function setFecEnt($fecDis)
    {
        $this->FecEnt = $fecDis;
    
        return $this;
    }

    /**
     * Get FecEnt
     *
     * @return \DateTime 
     */
    public function getFecEnt()
    {
        return $this->FecEnt;
    }

    /**
     * Set FPD
     *
     * @param \DateTime $fPD
     * @return Pedidos
     */
    public function setFPD($fPD)
    {
        $this->FPD = $fPD;
    
        return $this;
    }

    /**
     * Get FPD
     *
     * @return \DateTime 
     */
    public function getFPD()
    {
        return $this->FPD;
    }

    /**
     * Set RoundVentas
     *
     * @param \DateTime $roundVentas
     * @return Pedidos
     */
    public function setRoundVentas($roundVentas)
    {
        $this->RoundVentas = $roundVentas;
    
        return $this;
    }

    /**
     * Get RoundVentas
     *
     * @return \DateTime 
     */
    public function getRoundVentas()
    {
        return $this->RoundVentas;
    }
}