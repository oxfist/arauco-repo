<?php

namespace Arauco\CSVBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

ini_set('memory_limit', '-1');

class BalanceController extends Controller
{    
    /**
     * @Route("/balance", name="arauco_balance_index")
     * @Template("AraucoBaseBundle:Balance:index.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $stock = $em->getRepository('AraucoCSVBundle:Stock')
                ->findAllTotalStock();
        $pedidos = $em->getRepository('AraucoCSVBundle:Pedidos')
                ->findAllTotalPedidos();
        
        $total = array();
        
        foreach ($stock as $item) {
            $material = $item['Material'];
            $descMaterial = $item['Desc_Mat'];
            $stock = $item['Suma'];
            $totalPedidos = NULL;
            $balance = NULL;
            foreach ($pedidos as $pedido) {
                if ( $pedido['Material'] == $material ) {
                    $totalPedidos = $pedido['Suma'];
                    $balance = $stock - $totalPedidos;
                    unset( $pedidos[$material] );
                }
            }
            
            array_push( $total, array( $material, $descMaterial,
                $stock, $totalPedidos, $balance ) );
        }
        
        return array(
            'stock' => $stock,
            'pedidos' => $pedidos,
            'total' => $total
            );
    }
}