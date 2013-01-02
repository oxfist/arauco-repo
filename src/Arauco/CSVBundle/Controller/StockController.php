<?php

namespace Arauco\CSVBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Arauco\CSVBundle\Entity\Stock;

class StockController extends Controller
{
    
    /**
     * @Route("/stock", name="arauco_stock_index")
     * @Template("AraucoBaseBundle:Stock:index.html.twig")
     */
    public function importAction ( ) {

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                "SELECT COUNT ( S.Lote )
                FROM AraucoCSVBundle:Stock S
                WHERE S.Status <> 'A'"
                );
        $total = $query->getSingleScalarResult();
        return array('total' => $total);

    }
}
