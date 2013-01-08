<?php

namespace Arauco\CSVBundle\Controller;

use Arauco\CSVBundle\Entity\Stock;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class BalanceController extends Controller
{    
    /**
     * @Route("/balance", name="arauco_balance_index")
     * @Template("AraucoBaseBundle:Balance:index.html.twig")
     */
    public function indexAction()
    {  
        #$em = $this->getDoctrine()->getManager();
        #$query = $em->createQuery(
        #        "SELECT P.Material, s.t - sum(P.VolPedido) suma
        #         FROM AraucoCSVBundle:Pedidos P, (SELECT S.Material, sum(S.VolUtil+S.VolTran+S.Bloqueado) t from AraucoCSVBundle:Stock S group by S.Material) s
        #         group by P.Material");
        #$masa = $query->getResult();

        $em = $this->getDoctrine()->getManager();
        $stock = $em->getRepository('AraucoCSVBundle:Stock')
                ->findAllTotalInInventory();
        
        return array('stock' => $stock);
    }
}