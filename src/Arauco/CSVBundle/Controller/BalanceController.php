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
            $totalPedidosPorMaterial = NULL;
            $balance = NULL;
            $totalBalance = 0;
            $totalStock = 0;
            $totalPedidos = 0;
            
            foreach ($pedidos as $pedido) {
                if ( $pedido['Material'] == $material ) {
                    $totalPedidosPorMaterial = $pedido['Suma'];
                    $balance = $stock - $totalPedidosPorMaterial;
                    unset( $pedidos[$material] );
                    break;
                }
            }
            
            if ( !$totalPedidosPorMaterial ) {
                $totalPedidosPorMaterial = 0;
                $balance = $stock;
            }
            
            array_push( $total, array( $material, $descMaterial,
                $stock, $totalPedidosPorMaterial, $balance ) );
        }
        
        foreach ( $total as $item ) {
            $totalStock = $totalStock + $item[2];
            $totalPedidos = $totalPedidos + $item[3];
            $totalBalance = $totalBalance + $item[4];
        }
        
        usort( $total, array( $this, "Compare" ) );
        
        return array(
            'total' => $total,
            'totalBalance' => $totalBalance,
            'totalStock' => $totalStock,
            'totalPedidos' => $totalPedidos
            );
    }
    
    private static function Compare( $a, $b )
    {
        return $a[4] < $b[4];
    }
}