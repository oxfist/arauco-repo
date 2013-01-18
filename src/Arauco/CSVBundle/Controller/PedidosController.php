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

            # COMPLETAR CONSULTA
            $query = $em->createQuery("
                SELECT
                    SUM( S.M3 ) as M3
                FROM
                    AraucoCSVBundle:Pedidos P,
                    AraucoCSVBundle:Stock S
                WHERE
                    P.DocEntrega = S.Nro_Entrega
                    AND P.PosPedido = S.Pos_Entrega
                    AND P.Eta >='".$start_week."'
                    AND P.Eta <='".$end_week."'
                    AND P.StatusComplete IS NULL
                    AND P.StatusMovimientodeMcia != 'A'
                    ");

            $cantEntregasCompletas[$i] = $query->getSingleScalarResult();
            
            $query2 = $em->createQuery("
                SELECT
                    SUM( S.M3 ) as M3
                FROM
                    AraucoCSVBundle:Pedidos P,
                    AraucoCSVBundle:Stock S
                WHERE
                    P.DocEntrega = S.Nro_Entrega
                    AND P.PosPedido = S.Pos_Entrega
                    AND P.Eta >='".$start_week."'
                    AND P.Eta <='".$end_week."'
                    AND P.StatusComplete = 'NO'
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantEntregasCompletables[$i] = $query2->getSingleScalarResult();

            $query3 = $em->createQuery("
                SELECT
                    SUM( S.M3 ) as M3
                FROM
                    AraucoCSVBundle:Pedidos P,
                    AraucoCSVBundle:Stock S
                WHERE
                    P.DocEntrega = S.Nro_Entrega
                    AND P.PosPedido = S.Pos_Entrega
                    AND P.Eta >='".$start_week."'
                    AND P.Eta <='".$end_week."'
                    AND P.StatusComplete IS NULL
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantEntregasIncompletas[$i] = $query3->getSingleScalarResult();
        }

        return array(
            'cantEntregasCompletas' => $cantEntregasCompletas,
            'cantEntregasCompletables' => $cantEntregasCompletables,
            'cantEntregasIncompletas' => $cantEntregasIncompletas
            );
    }

    /**
     * @Route("/pedido/{week}", name="arauco_pedido_extend")
     * @Template("AraucoBaseBundle:Pedido:extend.html.twig")
     */
    public function extendAction ($week)
    {
        $cantOfWeeks = $week;

        $day = date('d', strtotime("+". $cantOfWeeks." week"));
        $month = date('m', strtotime("+". $cantOfWeeks." week"));
        $year = date('Y', strtotime("+". $cantOfWeeks." week"));

        $weekday = date('w', mktime(0,0,0,$month, $day, $year));
        $sunday  = $day - $weekday;

        $start_week = date('Y-m-d', mktime(0,0,0,$month, $sunday+1, $year));
        $end_week   = date('Y-m-d', mktime(0,0,0,$month, $sunday+7, $year)); 

        $sWeek = date('d/m/Y', mktime(0,0,0,$month, $sunday+1, $year));
        $eWeek   = date('d/m/Y', mktime(0,0,0,$month, $sunday+7, $year));


        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("
            SELECT
                P.DocEntrega,
                P.PosPedido,
                S.Material,
                S.Desc_Mat,
                P.VolPedido,
                SUM( S.M3 ) as M3
            FROM
                AraucoCSVBundle:Pedidos P,
                AraucoCSVBundle:Stock S
            WHERE
                P.DocEntrega = S.Nro_Entrega
                AND P.PosPedido = S.Pos_Entrega
                AND P.Eta >='".$start_week."'
                AND P.Eta <='".$end_week."'
                AND P.StatusMovimientodeMcia = 'A'
            GROUP BY
                P.DocEntrega,
                P.PosPedido
            ORDER BY
                P.DocEntrega
                ");

        $EntregasAsignadas = $query->getResult();

        $query2 = $em->createQuery("
            SELECT
                P.DocEntrega,
                P.PosPedido,
                S.Material,
                S.Desc_Mat,
                P.VolPedido,
                SUM( S.M3 ) as M3
            FROM
                AraucoCSVBundle:Pedidos P,
                AraucoCSVBundle:Stock S
            WHERE
                P.DocEntrega = S.STO_DOCENTREGA_ASI_ETA
                AND P.PosPedido = S.STO_POSPEDIDO_ASI_ETA
                AND P.Eta >='".$start_week."'
                AND P.Eta <='".$end_week."'
                AND P.StatusMovimientodeMcia = 'A'
            GROUP BY
                P.DocEntrega,
                P.PosPedido
            ORDER BY
                P.DocEntrega
                ");

        $EntregasETA = $query2->getResult();

        $query3 = $em->createQuery("
            SELECT
                P.DocEntrega,
                P.PosPedido,
                S.Material,
                S.Desc_Mat,
                P.VolPedido,
                SUM( S.M3 ) as M3
            FROM
                AraucoCSVBundle:Pedidos P,
                AraucoCSVBundle:Stock S
            WHERE
                P.DocEntrega = S.STO_DOCENTREGA_ASI_FPE
                AND P.PosPedido = S.STO_POSPEDIDO_ASI_FPE
                AND P.Eta >='".$start_week."'
                AND P.Eta <='".$end_week."'
                AND P.StatusMovimientodeMcia = 'A'
            GROUP BY
                P.DocEntrega,
                P.PosPedido
            ORDER BY
                P.DocEntrega");

        $EntregasFPE = $query3->getResult();

        /*
         * AGREGAR FOREACHS ACA
         */

        return array(
            'Entregas' => $EntregasAsignadas,
            'sWeek' => $sWeek,
            'eWeek' => $eWeek,
            'week' => $week);
    }

    /**
     * @Route("/pedido/{week}/csv", name="arauco_pedido_extendcsv")
     */
    public function extendcsvAction ($week)
    {
        $cantOfWeeks = $week;

        $day = date('d', strtotime("+". $cantOfWeeks." week"));
        $month = date('m', strtotime("+". $cantOfWeeks." week"));
        $year = date('Y', strtotime("+". $cantOfWeeks." week"));

        $weekday = date('w', mktime(0,0,0,$month, $day, $year));
        $sunday  = $day - $weekday;

        $start_week = date('Y-m-d', mktime(0,0,0,$month, $sunday+1, $year));
        $end_week   = date('Y-m-d', mktime(0,0,0,$month, $sunday+7, $year)); 

        $sWeek = date('d/m/Y', mktime(0,0,0,$month, $sunday+1, $year));
        $eWeek   = date('d/m/Y', mktime(0,0,0,$month, $sunday+7, $year)); 

        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery("
            SELECT
                P.DocEntrega,
                P.PosPedido,
                S.Material,
                S.Desc_Mat,
                P.VolPedido,
                SUM( S.M3 ) as M3
            FROM
                AraucoCSVBundle:Pedidos P,
                AraucoCSVBundle:Stock S
            WHERE
                P.DocEntrega = S.Nro_Entrega
                AND P.PosPedido = S.Pos_Entrega
                AND P.Eta >='".$start_week."'
                AND P.Eta <='".$end_week."'
                AND P.StatusMovimientodeMcia = 'A'
            GROUP BY
                P.DocEntrega,
                P.PosPedido
            ORDER BY
                P.DocEntrega
                ");

        $data = $query->getResult();

        $filename = "Pedidos_".$start_week."_".$end_week."_".date("Y_m_d_His").".csv";

        $response = $this->render('AraucoBaseBundle:Pedido:pedidosCsv.html.twig', array('data' => $data));

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);

        return $response;
    }
}
