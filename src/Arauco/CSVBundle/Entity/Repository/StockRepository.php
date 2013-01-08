<?php

namespace Arauco\CSVBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * StockRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StockRepository extends EntityRepository
{
    public function findAllTotalInInventory()
    {
        return $this->getEntityManager()->createQuery('
            SELECT s.Material, s.Desc_Mat,
            sum(s.Vol_Util)+sum(s.Vol_Tran)+sum(s.Bloqueado) Suma
            FROM AraucoCSVBundle:Stock s
            GROUP By s.Material
            ')->getResult();
    }
}

//Total en inventario
//SELECT Material, Desc_Mat, sum(Vol_Util)+sum(Vol_Tran)+sum(Bloqueado) Suma
//FROM Stock
//GROUP BY Material;