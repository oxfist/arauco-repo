<?php

namespace Arauco\CSVBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stock
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Stock
{
    /**
     * @var string
     *
     * @ORM\Column(name="Clase", type="string", length=255 , nullable=true)
     */
    private $Clase;

    /**
     * @var float
     *
     * @ORM\Id
     * @ORM\Column(name="Lote", type="float" , nullable=true)
     */
    private $Lote;

    /**
     * @var float
     *
     * @ORM\Column(name="Fecha_de_Creacion", type="float" , nullable=true)
     */
    private $Fecha_de_Creacion;

    /**
     * @var string
     *
     * @ORM\Column(name="UMB", type="string", length=255 , nullable=true)
     */
    private $UMB;

    /**
     * @var string
     *
     * @ORM\Column(name="Centro", type="string", length=255 , nullable=true)
     */
    private $Centro;

    /**
     * @var string
     *
     * @ORM\Column(name="Desc_Centro", type="string", length=255 , nullable=true)
     */
    private $Desc_Centro;

    /**
     * @var float
     *
     * @ORM\Column(name="Almacen", type="float" , nullable=true)
     */
    private $Almacen;

    /**
     * @var string
     *
     * @ORM\Column(name="Desc_Alm", type="string", length=255 , nullable=true)
     */
    private $Desc_Alm;

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
     * @var float
     *
     * @ORM\Column(name="Vol_Util", type="float" , nullable=true)
     */
    private $Vol_Util;

    /**
     * @var float
     *
     * @ORM\Column(name="Vol_Tran", type="float" , nullable=true)
     */
    private $Vol_Tran;

    /**
     * @var float
     *
     * @ORM\Column(name="Bloqueado", type="float" , nullable=true)
     */
    private $Bloqueado;

    /**
     * @var string
     *
     * @ORM\Column(name="Jerarquia", type="string", length=255 , nullable=true)
     */
    private $Jerarquia;

    /**
     * @var string
     *
     * @ORM\Column(name="Desc_Jer", type="string", length=255 , nullable=true)
     */
    private $Desc_Jer;

    /**
     * @var string
     *
     * @ORM\Column(name="Grpo_Art", type="string", length=255 , nullable=true)
     */
    private $Grpo_Art;

    /**
     * @var string
     *
     * @ORM\Column(name="Descrip_Grpo_Art", type="string", length=255 , nullable=true)
     */
    private $Descrip_Grpo_Art;

    /**
     * @var string
     *
     * @ORM\Column(name="Clase_de_Valoracion", type="string", length=255 , nullable=true)
     */
    private $Clase_de_Valoracion;

    /**
     * @var float
     *
     * @ORM\Column(name="M3", type="float" , nullable=true)
     */
    private $M3;

    /**
     * @var string
     *
     * @ORM\Column(name="Status", type="string", length=10 , nullable=true)
     */
    private $Status;

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
     * @var \string
     *
     * @ORM\Column(name="Fch_Creacion", type="string", length=255 , nullable=true)
     */
    private $Fch_Creacion;

    /**
     * @var string
     *
     * @ORM\Column(name="Defecto", type="string", length=3 , nullable=true)
     */
    private $Defecto;

    /**
     * @var float
     *
     * @ORM\Column(name="Esp_Real_Mm", type="float" , nullable=true)
     */
    private $Esp_Real_Mm;

    /**
     * @var float
     *
     * @ORM\Column(name="Anc_Real_Mm", type="float" , nullable=true)
     */
    private $Anc_Real_Mm;


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
     * Set Clase
     *
     * @param string $clase
     * @return Stock
     */
    public function setClase($clase)
    {
        $this->Clase = $clase;
    
        return $this;
    }

    /**
     * Get Clase
     *
     * @return string 
     */
    public function getClase()
    {
        return $this->Clase;
    }

    /**
     * Set Lote
     *
     * @param float $lote
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
     * @return float 
     */
    public function getLote()
    {
        return $this->Lote;
    }

    /**
     * Set Fecha_de_Creacion
     *
     * @param float $fechaDeCreacion
     * @return Stock
     */
    public function setFechaDeCreacion($fechaDeCreacion)
    {
        $this->Fecha_de_Creacion = $fechaDeCreacion;
    
        return $this;
    }

    /**
     * Get Fecha_de_Creacion
     *
     * @return float 
     */
    public function getFechaDeCreacion()
    {
        return $this->Fecha_de_Creacion;
    }

    /**
     * Set UMB
     *
     * @param string $uMB
     * @return Stock
     */
    public function setUMB($uMB)
    {
        $this->UMB = $uMB;
    
        return $this;
    }

    /**
     * Get UMB
     *
     * @return string 
     */
    public function getUMB()
    {
        return $this->UMB;
    }

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
     * Set Desc_Centro
     *
     * @param string $descCentro
     * @return Stock
     */
    public function setDescCentro($descCentro)
    {
        $this->Desc_Centro = $descCentro;
    
        return $this;
    }

    /**
     * Get Desc_Centro
     *
     * @return string 
     */
    public function getDescCentro()
    {
        return $this->Desc_Centro;
    }

    /**
     * Set Almacen
     *
     * @param float $almacen
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
     * @return float 
     */
    public function getAlmacen()
    {
        return $this->Almacen;
    }

    /**
     * Set Desc_Alm
     *
     * @param string $descAlm
     * @return Stock
     */
    public function setDescAlm($descAlm)
    {
        $this->Desc_Alm = $descAlm;
    
        return $this;
    }

    /**
     * Get Desc_Alm
     *
     * @return string 
     */
    public function getDescAlm()
    {
        return $this->Desc_Alm;
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
     * Set Vol_Util
     *
     * @param float $volUtil
     * @return Stock
     */
    public function setVolUtil($volUtil)
    {
        $this->Vol_Util = $volUtil;
    
        return $this;
    }

    /**
     * Get Vol_Util
     *
     * @return float 
     */
    public function getVolUtil()
    {
        return $this->Vol_Util;
    }

    /**
     * Set Vol_Tran
     *
     * @param float $volTran
     * @return Stock
     */
    public function setVolTran($volTran)
    {
        $this->Vol_Tran = $volTran;
    
        return $this;
    }

    /**
     * Get Vol_Tran
     *
     * @return float 
     */
    public function getVolTran()
    {
        return $this->Vol_Tran;
    }

    /**
     * Set Bloqueado
     *
     * @param float $bloqueado
     * @return Stock
     */
    public function setBloqueado($bloqueado)
    {
        $this->Bloqueado = $bloqueado;
    
        return $this;
    }

    /**
     * Get Bloqueado
     *
     * @return float 
     */
    public function getBloqueado()
    {
        return $this->Bloqueado;
    }

    /**
     * Set Jerarquia
     *
     * @param string $jerarquia
     * @return Stock
     */
    public function setJerarquia($jerarquia)
    {
        $this->Jerarquia = $jerarquia;
    
        return $this;
    }

    /**
     * Get Jerarquia
     *
     * @return string 
     */
    public function getJerarquia()
    {
        return $this->Jerarquia;
    }

    /**
     * Set Desc_Jer
     *
     * @param string $descJer
     * @return Stock
     */
    public function setDescJer($descJer)
    {
        $this->Desc_Jer = $descJer;
    
        return $this;
    }

    /**
     * Get Desc_Jer
     *
     * @return string 
     */
    public function getDescJer()
    {
        return $this->Desc_Jer;
    }

    /**
     * Set Grpo_Art
     *
     * @param string $grpoArt
     * @return Stock
     */
    public function setGrpoArt($grpoArt)
    {
        $this->Grpo_Art = $grpoArt;
    
        return $this;
    }

    /**
     * Get Grpo_Art
     *
     * @return string 
     */
    public function getGrpoArt()
    {
        return $this->Grpo_Art;
    }

    /**
     * Set Descrip_Grpo_Art
     *
     * @param string $descripGrpoArt
     * @return Stock
     */
    public function setDescripGrpoArt($descripGrpoArt)
    {
        $this->Descrip_Grpo_Art = $descripGrpoArt;
    
        return $this;
    }

    /**
     * Get Descrip_Grpo_Art
     *
     * @return string 
     */
    public function getDescripGrpoArt()
    {
        return $this->Descrip_Grpo_Art;
    }

    /**
     * Set Clase_de_Valoracion
     *
     * @param string $claseDeValoracion
     * @return Stock
     */
    public function setClaseDeValoracion($claseDeValoracion)
    {
        $this->Clase_de_Valoracion = $claseDeValoracion;
    
        return $this;
    }

    /**
     * Get Clase_de_Valoracion
     *
     * @return string 
     */
    public function getClaseDeValoracion()
    {
        return $this->Clase_de_Valoracion;
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
     * Set Fch_Creacion
     *
     * @param string $fchCreacion
     * @return Stock
     */
    public function setFchCreacion($fchCreacion)
    {
        $this->Fch_Creacion = $fchCreacion;
    
        return $this;
    }

    /**
     * Get Fch_Creacion
     *
     * @return string 
     */
    public function getFchCreacion()
    {
        return $this->Fch_Creacion;
    }

    /**
     * Set Defecto
     *
     * @param string $defecto
     * @return Stock
     */
    public function setDefecto($defecto)
    {
        $this->Defecto = $defecto;
    
        return $this;
    }

    /**
     * Get Defecto
     *
     * @return string 
     */
    public function getDefecto()
    {
        return $this->Defecto;
    }

    /**
     * Set Esp_Real_Mm
     *
     * @param float $espRealMm
     * @return Stock
     */
    public function setEspRealMm($espRealMm)
    {
        $this->Esp_Real_Mm = $espRealMm;
    
        return $this;
    }

    /**
     * Get Esp_Real_Mm
     *
     * @return float 
     */
    public function getEspRealMm()
    {
        return $this->Esp_Real_Mm;
    }

    /**
     * Set Anc_Real_Mm
     *
     * @param float $ancRealMm
     * @return Stock
     */
    public function setAncRealMm($ancRealMm)
    {
        $this->Anc_Real_Mm = $ancRealMm;
    
        return $this;
    }

    /**
     * Get Anc_Real_Mm
     *
     * @return float 
     */
    public function getAncRealMm()
    {
        return $this->Anc_Real_Mm;
    }
}
