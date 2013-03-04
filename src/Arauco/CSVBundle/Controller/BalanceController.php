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

        $totalBalance = 0;
        $totalStock = 0;
        $totalPedidos = 0;

        $total = array();

        foreach ($pedidos as $item) {

            $material = $item['Material'];
            $descMaterial = $item['DescripcionMaterial'];
            $totalPedidosPorMaterial = $item['Suma'];
            $balance = NULL;
            $stockMaterial = NULL;

            foreach ($stock as $stockCurrent) {
                if ( $stockCurrent['Material'] == $material ) {
                    $stockMaterial = $stockCurrent['Suma'];
                    $balance = $stockMaterial - $totalPedidosPorMaterial;
                    unset( $pedidos[$material] );
                    break;
                }
            }

            if ( !$stockMaterial ) {
                $stockMaterial = 0;
                $balance = $totalPedidosPorMaterial * -1;
            }

array_push(
                    $total, array(
                        $material, $descMaterial, round( $stockMaterial, 3 ),
                        round($totalPedidosPorMaterial, 3) , round( $balance, 3 )
                        )
                    );


        }

        foreach ($stock as $item) {
            $material = $item['Material'];
            $descMaterial = $item['Desc_Mat'];
            $stockMaterial = $item['Suma'];
            $flag = NULL;
            $balance = NULL;

            foreach ($pedidos as $pedidoCurrent) {
                if ( $pedidoCurrent['Material'] == $material ) {
                    $flag = 1;
                    break;
                }
            }

            if ( !$flag ) {
                $balance = $stockMaterial;
                array_push(
                    $total, array(
                        $material, $descMaterial, round( $stockMaterial, 3 ),
                        0 , round( $balance, 3 )
                        )
                    );
            }

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

    /**
     * @Route("/balance/csv", name="arauco_balance_csv")
     */
    public function csvAction()
    {
        $em = $this->getDoctrine()->getManager();
        $stock = $em->getRepository('AraucoCSVBundle:Stock')
                ->findAllTotalStock();
        $pedidos = $em->getRepository('AraucoCSVBundle:Pedidos')
                ->findAllTotalPedidos();

        $total = array();

                foreach ($pedidos as $item) {

            $material = $item['Material'];
            $descMaterial = $item['DescripcionMaterial'];
            $totalPedidosPorMaterial = $item['Suma'];
            $balance = NULL;
            $stockMaterial = NULL;

            foreach ($stock as $stockCurrent) {
                if ( $stockCurrent['Material'] == $material ) {
                    $stockMaterial = $stockCurrent['Suma'];
                    $balance = $stockMaterial - $totalPedidosPorMaterial;
                    unset( $pedidos[$material] );
                    break;
                }
            }

            if ( !$stockMaterial ) {
                $stockMaterial = 0;
                $balance = $totalPedidosPorMaterial * -1;
            }

array_push(
                    $total, array(
                        $material, $descMaterial, round( $stockMaterial, 3 ),
                        round($totalPedidosPorMaterial, 3) , round( $balance, 3 )
                        )
                    );


        }

        foreach ($stock as $item) {
            $material = $item['Material'];
            $descMaterial = $item['Desc_Mat'];
            $stockMaterial = $item['Suma'];
            $flag = NULL;
            $balance = NULL;

            foreach ($pedidos as $pedidoCurrent) {
                if ( $pedidoCurrent['Material'] == $material ) {
                    $flag = 1;
                    break;
                }
            }

            if ( !$flag ) {
                $balance = $stockMaterial;
                array_push(
                    $total, array(
                        $material, $descMaterial, round( $stockMaterial, 3 ),
                        0 , round( $balance, 3 )
                        )
                    );
            }

        }

        foreach ( $total as $item ) {
            $totalStock = $totalStock + $item[2];
            $totalPedidos = $totalPedidos + $item[3];
            $totalBalance = $totalBalance + $item[4];
        }

        usort( $total, array( $this, "Compare" ) );

        $filename = "Balance".date("Y_m_d_His").".csv";

        $response = $this->render('AraucoBaseBundle:Balance:balanceCSV.html.twig', array('data' => $total ));

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);

        return $response;
    }

    private static function Compare( $a, $b )
    {
        return $a[4] < $b[4];
    }
}
