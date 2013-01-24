<?php

namespace Arauco\CSVBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Arauco\CSVBundle\Entity\Stock;
use Arauco\CSVBundle\Entity\Pedidos;

ini_set( 'memory_limit', '-1' );

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
                    AND P.StatusComplete = 'CPU'
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantEntregasCompletasEnPuerto[$i] = $query->getSingleScalarResult();

            if(!isset($cantEntregasCompletasEnPuerto[$i]))
                $cantEntregasCompletasEnPuerto[$i] = 0;

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
                    AND P.StatusComplete = 'CPL'
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantEntregasCompletasEnPlanta[$i] = $query2->getSingleScalarResult();

            if(!isset($cantEntregasCompletasEnPlanta[$i]))
                $cantEntregasCompletasEnPlanta[$i] = 0;

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
                    AND P.StatusComplete = 'NO'
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantEntregasIncompletas[$i] = $query3->getSingleScalarResult();

        }

        return array(
            'cantEntregasCompletasEnPuerto' => $cantEntregasCompletasEnPuerto,
            'cantEntregasCompletasEnPlanta' => $cantEntregasCompletasEnPlanta,
            'cantEntregasIncompletas' => $cantEntregasIncompletas
            );
    }

    /**
     * @Route("/pedido/comcpu/{week}", name="arauco_pedido_extend_com_cpu")
     * @Template("AraucoBaseBundle:Pedido:extend.html.twig")
     */
    public function extendcomcpuAction ($week)
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
                AND P.StatusComplete = 'CPU'
                AND P.StatusMovimientodeMcia = 'A'
            GROUP BY
                P.DocEntrega,
                P.PosPedido
            ORDER BY
                P.DocEntrega,
                P.PosPedido
                ");

        $EntregasAsignadas = $query->getResult();

        $query2 = $em->createQuery("
            SELECT
                P.DocEntrega,
                P.PosPedido,
                SUM( S.M3 ) as M3
            FROM
                AraucoCSVBundle:Pedidos P,
                AraucoCSVBundle:Stock S
            WHERE
                P.DocEntrega = S.STO_DOCENTREGA_ASI_ETA
                AND P.PosPedido = S.STO_POSPEDIDO_ASI_ETA
                AND P.Eta >='".$start_week."'
                AND P.Eta <='".$end_week."'
                AND P.StatusComplete = 'CPU'
                AND P.StatusMovimientodeMcia = 'A'
            GROUP BY
                P.DocEntrega,
                P.PosPedido
            ORDER BY
                P.DocEntrega,
                P.PosPedido
                ");

        $EntregasETA = $query2->getResult();

        $query3 = $em->createQuery("
            SELECT
                P.DocEntrega,
                P.PosPedido,
                SUM( S.M3 ) as M3
            FROM
                AraucoCSVBundle:Pedidos P,
                AraucoCSVBundle:Stock S
            WHERE
                P.DocEntrega = S.STO_DOCENTREGA_ASI_FPE
                AND P.PosPedido = S.STO_POSPEDIDO_ASI_FPE
                AND P.Eta >='".$start_week."'
                AND P.Eta <='".$end_week."'
                AND P.StatusComplete = 'CPU'
                AND P.StatusMovimientodeMcia = 'A'
            GROUP BY
                P.DocEntrega,
                P.PosPedido
            ORDER BY
                P.DocEntrega,
                P.PosPedido
            ");

        $EntregasFPE = $query3->getResult();

        $entregasFinal = array();

        foreach ( $EntregasAsignadas as $item ) {

            $docEntrega = $item['DocEntrega'];
            $posPedido = $item['PosPedido'];
            $material = $item['Material'];
            $descripcion = $item['Desc_Mat'];
            $volPedido = $item['VolPedido'];
            $sumaVolAsignado = $item['M3'];
            $sumaVolAsiETA = 0;
            $sumaVolAsiFPE = 0;

            foreach ( $EntregasETA as $item ) {

                if ( $docEntrega == $item['DocEntrega']
                    && $posPedido == $item['PosPedido'] ) {
                    $sumaVolAsiETA = $item['M3'];
                    unset( $EntregasETA[ $docEntrega ] );
                    break;
                }

            }

            foreach ( $EntregasFPE as $item ) {

                if ( $docEntrega == $item['DocEntrega']
                    && $posPedido == $item['PosPedido'] ) {
                    $sumaVolAsiFPE = $item['M3'];
                    unset( $EntregasFPE[ $docEntrega ] );
                    break;
                }

            }

            array_push(
                $entregasFinal, array(
                    $docEntrega, $posPedido, $material, $descripcion,
                    $volPedido, round( $sumaVolAsignado, 3 ),
                    round( $sumaVolAsiETA, 3 ),
                    round( $sumaVolAsiFPE, 3 )
                )
            );

        }

        return array(
            'Entregas' => $entregasFinal,
            'sWeek' => $sWeek,
            'eWeek' => $eWeek,
            'week' => $week
        );
    }

    /**
     * @Route("/pedido/comcpl/{week}", name="arauco_pedido_extend_com_cpl")
     * @Template("AraucoBaseBundle:Pedido:extend.html.twig")
     */
    public function extendcomcplAction ($week)
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
                AND P.StatusComplete = 'CPL'
                AND P.StatusMovimientodeMcia = 'A'
            GROUP BY
                P.DocEntrega,
                P.PosPedido
            ORDER BY
                P.DocEntrega,
                P.PosPedido
                ");

        $EntregasAsignadas = $query->getResult();

        $query2 = $em->createQuery("
            SELECT
                P.DocEntrega,
                P.PosPedido,
                SUM( S.M3 ) as M3
            FROM
                AraucoCSVBundle:Pedidos P,
                AraucoCSVBundle:Stock S
            WHERE
                P.DocEntrega = S.STO_DOCENTREGA_ASI_ETA
                AND P.PosPedido = S.STO_POSPEDIDO_ASI_ETA
                AND P.Eta >='".$start_week."'
                AND P.Eta <='".$end_week."'
                AND P.StatusComplete = 'CPL'
                AND P.StatusMovimientodeMcia = 'A'
            GROUP BY
                P.DocEntrega,
                P.PosPedido
            ORDER BY
                P.DocEntrega,
                P.PosPedido
                ");

        $EntregasETA = $query2->getResult();

        $query3 = $em->createQuery("
            SELECT
                P.DocEntrega,
                P.PosPedido,
                SUM( S.M3 ) as M3
            FROM
                AraucoCSVBundle:Pedidos P,
                AraucoCSVBundle:Stock S
            WHERE
                P.DocEntrega = S.STO_DOCENTREGA_ASI_FPE
                AND P.PosPedido = S.STO_POSPEDIDO_ASI_FPE
                AND P.Eta >='".$start_week."'
                AND P.Eta <='".$end_week."'
                AND P.StatusComplete = 'CPL'
                AND P.StatusMovimientodeMcia = 'A'
            GROUP BY
                P.DocEntrega,
                P.PosPedido
            ORDER BY
                P.DocEntrega,
                P.PosPedido
            ");

        $EntregasFPE = $query3->getResult();

        $entregasFinal = array();

        foreach ( $EntregasAsignadas as $item ) {

            $docEntrega = $item['DocEntrega'];
            $posPedido = $item['PosPedido'];
            $material = $item['Material'];
            $descripcion = $item['Desc_Mat'];
            $volPedido = $item['VolPedido'];
            $sumaVolAsignado = $item['M3'];
            $sumaVolAsiETA = 0;
            $sumaVolAsiFPE = 0;

            foreach ( $EntregasETA as $item ) {

                if ( $docEntrega == $item['DocEntrega']
                    && $posPedido == $item['PosPedido'] ) {
                    $sumaVolAsiETA = $item['M3'];
                    unset( $EntregasETA[ $docEntrega ] );
                    break;
                }

            }

            foreach ( $EntregasFPE as $item ) {

                if ( $docEntrega == $item['DocEntrega']
                    && $posPedido == $item['PosPedido'] ) {
                    $sumaVolAsiFPE = $item['M3'];
                    unset( $EntregasFPE[ $docEntrega ] );
                    break;
                }

            }

            array_push(
                $entregasFinal, array(
                    $docEntrega, $posPedido, $material, $descripcion,
                    $volPedido, round( $sumaVolAsignado, 3 ),
                    round( $sumaVolAsiETA, 3 ),
                    round( $sumaVolAsiFPE, 3 )
                )
            );

        }

        return array(
            'Entregas' => $entregasFinal,
            'sWeek' => $sWeek,
            'eWeek' => $eWeek,
            'week' => $week
        );
    }

    /**
     * @Route("/pedido/inc/{week}", name="arauco_pedido_extend_inc")
     * @Template("AraucoBaseBundle:Pedido:extend.html.twig")
     */
    public function extendincAction ($week)
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
                AND P.StatusComplete = 'NO'
                AND P.StatusMovimientodeMcia = 'A'
            GROUP BY
                P.DocEntrega,
                P.PosPedido
            ORDER BY
                P.DocEntrega ASC
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
                AND P.StatusComplete = 'NO'
                AND P.StatusMovimientodeMcia = 'A'
            GROUP BY
                P.DocEntrega,
                P.PosPedido
            ORDER BY
                P.DocEntrega ASC
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
                AND P.StatusComplete = 'NO'
                AND P.StatusMovimientodeMcia = 'A'
            GROUP BY
                P.DocEntrega,
                P.PosPedido
            ORDER BY
                P.DocEntrega ASC");

        $EntregasFPE = $query3->getResult();

        $entregasFinal = array();

        foreach ( $EntregasAsignadas as $entrega ) {

            $docEntrega = $entrega['DocEntrega'];
            $posPedido = $entrega['PosPedido'];
            $material = $entrega['Material'];
            $descripcion = $entrega['Desc_Mat'];
            $volPedido = $entrega['VolPedido'];
            $sumaVolAsignado = $entrega['M3'];
            $sumaVolAsiETA = 0;
            $sumaVolAsiFPE = 0;

            foreach ( $EntregasETA as $item ) {

                if ( $docEntrega == $item['DocEntrega']
                    && $posPedido == $item['PosPedido'] ) {
                    $sumaVolAsiETA = $item['M3'];
                    unset( $EntregasETA[ $docEntrega ] );
                    break;
                }

            }

            foreach ( $EntregasFPE as $item ) {

                if ( $docEntrega == $item['DocEntrega']
                    && $posPedido == $item['PosPedido'] ) {
                    $sumaVolAsiFPE = $item['M3'];
                    unset( $EntregasFPE[ $docEntrega ] );
                    break;
                }

            }

            array_push(
                $entregasFinal, array(
                    $docEntrega, $posPedido, $material, $descripcion,
                    $volPedido, round( $sumaVolAsignado, 3 ),
                    round( $sumaVolAsiETA, 3 ),
                    round( $sumaVolAsiFPE, 3 )
                )
            );

        }

        return array(
            'Entregas' => $entregasFinal,
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
                AND P.StatusComplete = 'NO'
                AND P.StatusMovimientodeMcia = 'A'
            GROUP BY
                P.DocEntrega,
                P.PosPedido
            ORDER BY
                P.DocEntrega ASC
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
                AND P.StatusComplete = 'NO'
                AND P.StatusMovimientodeMcia = 'A'
            GROUP BY
                P.DocEntrega,
                P.PosPedido
            ORDER BY
                P.DocEntrega ASC
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
                AND P.StatusComplete = 'NO'
                AND P.StatusMovimientodeMcia = 'A'
            GROUP BY
                P.DocEntrega,
                P.PosPedido
            ORDER BY
                P.DocEntrega ASC");

        $EntregasFPE = $query3->getResult();

        $entregasFinal = array();

        foreach ( $EntregasAsignadas as $entrega ) {

            $docEntrega = $entrega['DocEntrega'];
            $posPedido = $entrega['PosPedido'];
            $material = $entrega['Material'];
            $descripcion = $entrega['Desc_Mat'];
            $volPedido = $entrega['VolPedido'];
            $sumaVolAsignado = $entrega['M3'];
            $sumaVolAsiETA = 0;
            $sumaVolAsiFPE = 0;

            foreach ( $EntregasETA as $item ) {

                if ( $docEntrega == $item['DocEntrega']
                    && $posPedido == $item['PosPedido'] ) {
                    $sumaVolAsiETA = $item['M3'];
                    unset( $EntregasETA[ $docEntrega ] );
                    break;
                }

            }

            foreach ( $EntregasFPE as $item ) {

                if ( $docEntrega == $item['DocEntrega']
                    && $posPedido == $item['PosPedido'] ) {
                    $sumaVolAsiFPE = $item['M3'];
                    unset( $EntregasFPE[ $docEntrega ] );
                    break;
                }

            }

            array_push(
                $entregasFinal, array(
                    $docEntrega, $posPedido, $material, $descripcion,
                    $volPedido, round( $sumaVolAsignado, 3 ),
                    round( $sumaVolAsiETA, 3 ),
                    round( $sumaVolAsiFPE, 3 )
                )
            );

        }

        $filename = "Pedidos_".$start_week."_".$end_week."_".date("Y_m_d_His").".csv";

        $response = $this->render('AraucoBaseBundle:Pedido:pedidosCsv.html.twig', array('data' => $entregasFinal ));

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);

        return $response;
    }
}
