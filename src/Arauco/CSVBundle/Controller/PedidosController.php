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
                    AND P.PED_COMPLETABLE_ETA = TRUE
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantEntregasCompletablesETA[$i] = $query3->getSingleScalarResult();

            if(!isset($cantEntregasCompletablesETA[$i]))
                $cantEntregasCompletablesETA[$i] = 0;

            $query31 = $em->createQuery("
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
                    AND P.PED_COMPLETABLE_FPE = TRUE
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantEntregasCompletablesFPE[$i] = $query31->getSingleScalarResult();

            if(!isset($cantEntregasCompletablesFPE[$i]))
                $cantEntregasCompletablesFPE[$i] = 0;

            $query4 = $em->createQuery("
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
                    AND P.PED_COMPLETABLE_ETA = FALSE
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantEntregasIncompletasETA[$i] = $query4->getSingleScalarResult();

            if(!isset($cantEntregasIncompletasETA[$i]))
                $cantEntregasIncompletasETA[$i] = 0;

            $query41 = $em->createQuery("
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
                    AND P.PED_COMPLETABLE_FPE = FALSE
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantEntregasIncompletasFPE[$i] = $query41->getSingleScalarResult();

            if(!isset($cantEntregasIncompletasFPE[$i]))
                $cantEntregasIncompletasFPE[$i] = 0;

        }

        return array(
            'cantEntregasCompletasEnPuerto' => $cantEntregasCompletasEnPuerto,
            'cantEntregasCompletasEnPlanta' => $cantEntregasCompletasEnPlanta,
            'cantEntregasCompletablesETA' => $cantEntregasCompletablesETA,
            'cantEntregasCompletablesFPE' => $cantEntregasCompletablesFPE,
            'cantEntregasIncompletasETA' => $cantEntregasIncompletasETA,
            'cantEntregasIncompletasFPE' => $cantEntregasIncompletasFPE
            );
    }

    /**
     * @Route("/pedido/comcpu/{week}", name="arauco_pedido_extend_com_cpu")
     * @Template("AraucoBaseBundle:Pedido:extendCPU.html.twig")
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

        $status = "CPU";
        $em = $this->getDoctrine()->getManager();
        $EntregasAsignadas = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosAsig($start_week, $end_week, $status);

        $EntregasETA = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosETA($start_week, $end_week, $status);

        $EntregasFPE = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosFPE($start_week, $end_week, $status);

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
     * @Template("AraucoBaseBundle:Pedido:extendCPL.html.twig")
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

        $status = "CPL";
        $em = $this->getDoctrine()->getManager();
        $EntregasAsignadas = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosAsig($start_week, $end_week, $status);

        $EntregasETA = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosETA($start_week, $end_week, $status);

        $EntregasFPE = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosFPE($start_week, $end_week, $status);

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
     * @Route("/pedido/complet/eta/{week}", name="arauco_pedido_extend_complet_eta")
     * @Template("AraucoBaseBundle:Pedido:extendINC.html.twig")
     */
    public function extendcompletaAction ($week)
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

        $status = "NO";
        $completable = TRUE;
        $em = $this->getDoctrine()->getManager();
        $EntregasAsignadas = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosAsigIncETA($start_week, $end_week, $status, $completable);

        $EntregasETA = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosETAIncETA($start_week, $end_week, $status, $completable);

        $EntregasFPE = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosFPEIncETA($start_week, $end_week, $status, $completable);

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
     * @Route("/pedido/inc/eta/{week}", name="arauco_pedido_extend_inc_eta")
     * @Template("AraucoBaseBundle:Pedido:extendINC.html.twig")
     */
    public function extendincetaAction ($week)
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

        $status = "NO";
        $completable = FALSE;
        $em = $this->getDoctrine()->getManager();
        $EntregasAsignadas = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosAsigIncETA($start_week, $end_week, $status, $completable);

        $EntregasETA = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosETAIncETA($start_week, $end_week, $status, $completable);

        $EntregasFPE = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosFPEIncETA($start_week, $end_week, $status, $completable);

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
     * @Route("/pedido/complet/fpe/{week}", name="arauco_pedido_extend_complet_fpe")
     * @Template("AraucoBaseBundle:Pedido:extendINC.html.twig")
     */
    public function extendcomplfpeAction ($week)
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

        $status = "NO";
        $completable = TRUE;
        $em = $this->getDoctrine()->getManager();
        $EntregasAsignadas = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosAsigIncFPE($start_week, $end_week, $status, $completable);

        $EntregasETA = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosETAIncFPE($start_week, $end_week, $status, $completable);

        $EntregasFPE = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosFPEIncFPE($start_week, $end_week, $status, $completable);

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
     * @Route("/pedido/inc/fpe/{week}", name="arauco_pedido_extend_inc_fpe")
     * @Template("AraucoBaseBundle:Pedido:extendINC.html.twig")
     */
    public function extendincfpeAction ($week)
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

        $status = "NO";
        $completable = FALSE;
        $em = $this->getDoctrine()->getManager();
        $EntregasAsignadas = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosAsigIncFPE($start_week, $end_week, $status, $completable);

        $EntregasETA = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosETAIncFPE($start_week, $end_week, $status, $completable);

        $EntregasFPE = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosFPEIncFPE($start_week, $end_week, $status, $completable);

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
     * @Route("/pedido/{week}/comcpu/csv", name="arauco_pedido_extendcsv_comcpu")
     */
    public function extendcsvcomcpuAction ($week)
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

        $status = "CPU";
        $em = $this->getDoctrine()->getManager();
        $EntregasAsignadas = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosAsig($start_week, $end_week, $status);

        $EntregasETA = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosETA($start_week, $end_week, $status);

        $EntregasFPE = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosFPE($start_week, $end_week, $status);

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

    /**
     * @Route("/pedido/{week}/comcpl/csv", name="arauco_pedido_extendcsv_comcpl")
     */
    public function extendcsvcomcplAction ($week)
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

        $status = "CPL";

        $em = $this->getDoctrine()->getManager();
        $EntregasAsignadas = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosAsig($start_week, $end_week, $status);

        $EntregasETA = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosETA($start_week, $end_week, $status);

        $EntregasFPE = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosFPE($start_week, $end_week, $status);

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

    /**
     * @Route("/pedido/{week}/inc/csv", name="arauco_pedido_extendcsv_inc")
     */
    public function extendcsvincAction ($week)
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

        $status = "NO";
        $em = $this->getDoctrine()->getManager();
        $EntregasAsignadas = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosAsig($start_week, $end_week, $status);

        $EntregasETA = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosETA($start_week, $end_week, $status);

        $EntregasFPE = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosFPE($start_week, $end_week, $status);

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
