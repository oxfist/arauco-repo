<?php

namespace Andres\Bundle\TestBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 *
 */

class Propietario extends \Andres\Bundle\TestBundle\Entity\Persona
{
    
    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

}
