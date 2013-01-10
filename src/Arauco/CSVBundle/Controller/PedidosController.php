<?php

namespace Arauco\CSVBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Arauco\CSVBundle\Entity\Stock;
use Arauco\CSVBundle\Entity\Pedidos;

class PedidosController extends Controller
{
    /**
     * @Route("/pedido", name="arauco_pedido_index")
     * @Template("AraucoBaseBundle:Pedido:index.html.twig")
     */
    public function importAction ()
    {
        for ($i = 0; $i < 4; $i++) {
            $cantOfWeeks = $i;

            $day = date('d', strtotime("+". $cantOfWeeks." week"));
            $month = date('m', strtotime("+". $cantOfWeeks." week"));
            $year = date('Y', strtotime("+". $cantOfWeeks." week"));

            $weekday = date('w', mktime(0,0,0,$month, $day, $year));
            $sunday  = $day - $weekday;

            $start_week = date('Ymd', mktime(0,0,0,$month, $sunday+1, $year));
            $end_week   = date('Ymd', mktime(0,0,0,$month, $sunday+7, $year)); 

            $em = $this->getDoctrine()->getManager();

            $query = $em->createQuery("SELECT P.DocEntrega, P.PosPedido, S.Material, S.Desc_Mat, P.VolPedido, SUM( S.M3 ) as M3 FROM AraucoCSVBundle:Pedidos P, AraucoCSVBundle:Stock S WHERE P.DocEntrega = S.Nro_Entrega AND P.PosPedido = S.Pos_Entrega AND P.Eta >=".$start_week."AND P.Eta <=".$end_week." AND P.StatusMovimientodeMcia = 'A' GROUP BY P.DocEntrega, P.PosPedido ORDER BY P.DocEntrega");

            $Entregas = $query->getResult();
            $cantEntregas[$i] = count($Entregas);
        }

        return array('cantEntregas' => $cantEntregas);
    }

    /**
     * @Route("/pedido/{id}", name="arauco_pedido_extend")
     * @Template("AraucoBaseBundle:Pedido:extend.html.twig")
     */
    public function extendAction ()
    {
        $cantOfWeeks = 2;

        $day = date('d', strtotime("+". $cantOfWeeks." week"));
        $month = date('m', strtotime("+". $cantOfWeeks." week"));
        $year = date('Y', strtotime("+". $cantOfWeeks." week"));

        $weekday = date('w', mktime(0,0,0,$month, $day, $year));
        $sunday  = $day - $weekday;

        $start_week = date('Ymd', mktime(0,0,0,$month, $sunday+1, $year));
        $end_week   = date('Ymd', mktime(0,0,0,$month, $sunday+7, $year)); 

        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery("SELECT P.DocEntrega, P.PosPedido, S.Material, S.Desc_Mat, P.VolPedido, SUM( S.M3 ) as M3 FROM AraucoCSVBundle:Pedidos P, AraucoCSVBundle:Stock S WHERE P.DocEntrega = S.Nro_Entrega AND P.PosPedido = S.Pos_Entrega AND P.Eta >=".$start_week."AND P.Eta <=".$end_week." AND P.StatusMovimientodeMcia = 'A' GROUP BY P.DocEntrega, P.PosPedido ORDER BY P.DocEntrega");

        $Entregas = $query->getResult();
        $cantEntregas = count($Entregas);

        return array('Entregas' => $Entregas, 'cantEntregas' => $cantEntregas);
    }
}
