<?php

namespace Arauco\CSVBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SysInfo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SysInfo
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
     * @var \DateTime
     *
     * @ORM\Column(name="lastUpdate", type="datetime")
     */
    private $LastUpdate;


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
     * Set lastUpdate
     *
     * @param \DateTime $lastUpdate
     * @return SysInfo
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->LastUpdate = $lastUpdate;
    
        return $this;
    }

    /**
     * Get lastUpdate
     *
     * @return \DateTime 
     */
    public function getLastUpdate()
    {
        return $this->LastUpdate;
    }
}