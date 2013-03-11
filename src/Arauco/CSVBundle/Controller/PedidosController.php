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
    private function dateconvert($cantOfWeeks) {

        $day = date('d', strtotime("+". $cantOfWeeks." week"));
        $month = date('m', strtotime("+". $cantOfWeeks." week"));
        $year = date('Y', strtotime("+". $cantOfWeeks." week"));

        $weekday = date('w', mktime(0,0,0,$month, $day, $year));
        $sunday  = $day - $weekday;

        $start_week = date('Ymd', mktime(0,0,0,$month, $sunday+1, $year));
        $end_week   = date('Ymd', mktime(0,0,0,$month, $sunday+7, $year));

        $sWeek = date('d/m/Y', mktime(0,0,0,$month, $sunday+1, $year));
        $eWeek   = date('d/m/Y', mktime(0,0,0,$month, $sunday+7, $year));

        return array(
            'start_week' => $start_week,
            'end_week' => $end_week,
            'sWeek' => $sWeek,
            'eWeek' => $eWeek,
            );

    }

    private function sortComplete($EntregasAsignadas, $EntregasETA, $EntregasFPE, $comstatus) {

        $entregasFinal = array();

        foreach ( $EntregasAsignadas as $item ) {

            $docEntrega = $item['DocEntrega'];
            $posPedido = $item['PosPedido'];
            $orgVenta = $item['OrgVenta'];
            $codCliente = $item['CodCliente'];
            $nomCliente = $item['NomCliente'];
            $material = $item['Material'];
            $descripcion = $item['Desc_Mat'];
            $volPedido = $item['VolPedido'];
            $PaisDestino = $item['PaisDestino'];
            $Destino = $item['Destino'];
            $eta = $item['Eta'];
            $fpe = $item['FPE'];
            $fpan = $item['FPAN'];
            $fpd = $item['FPD'];
            $FecDis = $item['FecDis'];
            $RoundVentas = $item['RoundVentas'];
            $MT = $item['MT'];
            $EntComp = $item['EntComp'];
            $Nave = $item['Nave'];
            $ClaseMaterial = $item['ClaseMaterial'];
            $sumaVolAsignado = $item['M3'];
            $sumaVolAsiETA = 0;
            $sumaVolAsiFPE = 0;

            foreach ( $EntregasETA as $item ) {

                if ( $docEntrega == $item['DocEntrega']
                    && $posPedido == $item['PosPedido'] ) {
                    $sumaVolAsiETA = $item['M3'];
                    break;
                }

            }

            foreach ( $EntregasFPE as $item ) {

                if ( $docEntrega == $item['DocEntrega']
                    && $posPedido == $item['PosPedido'] ) {
                    $sumaVolAsiFPE = $item['M3'];
                    break;
                }

            }

            if ($RoundVentas)
                $RoundVentas = $RoundVentas->format('Y-m');
            else
                $RoundVentas = "";

            array_push(
                $entregasFinal, array(
                    $docEntrega, // 0
                    $posPedido, // 1
                    $orgVenta, // 2
                    $eta->format('d-m-Y'), // 3
                    $fpe->format('d-m-Y'), // 4
                    $material, // 5
                    $descripcion, // 6
                    $volPedido, // 7
                    round( $sumaVolAsignado, 3 ), // 8
                    round( $sumaVolAsiETA, 3 ), // 9
                    round( $sumaVolAsiFPE, 3 ), // 10
                    $FecDis->format('d-m-Y'), // 11
                    $codCliente, // 12
                    $nomCliente, // 13
                    $EntComp, // 14
                    $Destino, // 15
                    $PaisDestino, // 16
                    $fpan->format('d-m-Y'), // 17
                    $fpd->format('d-m-Y'), // 18
                    $RoundVentas, // 19
                    $MT, // 20
                    $Nave, // 21
                    $ClaseMaterial, //22
                    $comstatus
                )
            );

        }


        return $entregasFinal;

    }

    private function sortIncomplete($Entregas, $EntregasM3, $EntregasETA, $EntregasFPE, $comstatus) {

        $entregasFinal = array();

        foreach ( $Entregas as $entrega ) {
            $docEntrega = $entrega['DocEntrega'];
            $posPedido = $entrega['PosPedido'];
            $orgVenta = $entrega['OrgVenta'];
            $codCliente = $entrega['CodCliente'];
            $nomCliente = $entrega['NomCliente'];
            $material = $entrega['Material'];
            $descripcion = $entrega['DescripcionMaterial'];
            $volPedido = $entrega['VolPedido'];
            $PaisDestino = $entrega['PaisDestino'];
            $Destino = $entrega['Destino'];
            $eta = $entrega['Eta'];
            $fpe = $entrega['FPE'];
            $fpan = $entrega['FPAN'];
            $fpd = $entrega['FPD'];
            $FecDis = $entrega['FecDis'];
            $RoundVentas = $entrega['RoundVentas'];
            $MT = $entrega['MT'];
            $EntComp = $entrega['EntComp'];
            $Nave = $entrega['Nave'];
            $ClaseMaterial = $entrega['ClaseMaterial'];

            $sumaVolAsignado = 0;
            $sumaVolAsiETA = 0;
            $sumaVolAsiFPE = 0;

            foreach ( $EntregasM3 as $item ) {

                if ( $docEntrega == $item['DocEntrega']
                    && $posPedido == $item['PosPedido'] ) {
                    $sumaVolAsignado = $item['M3'];
                    break;
                }

                if ($docEntrega < $item['DocEntrega'])
                    break;

            }

            foreach ( $EntregasETA as $item ) {

                if ( $docEntrega == $item['DocEntrega']
                    && $posPedido == $item['PosPedido'] ) {
                    $sumaVolAsiETA = $item['M3'];
                    break;
                }

                if ($docEntrega < $item['DocEntrega'])
                    break;

            }

            foreach ( $EntregasFPE as $item ) {

                if ( $docEntrega == $item['DocEntrega']
                    && $posPedido == $item['PosPedido'] ) {
                    $sumaVolAsiFPE = $item['M3'];
                    break;
                }
                if ($docEntrega < $item['DocEntrega'])
                    break;

            }

            if ($RoundVentas)
                $RoundVentas = $RoundVentas->format('Y-m');
            else
                $RoundVentas = "";

            array_push(
                $entregasFinal, array(
                    $docEntrega,
                    $posPedido,
                    $orgVenta,
                    $eta->format('d-m-Y'),
                    $fpe->format('d-m-Y'),
                    $material,
                    $descripcion,
                    $volPedido,
                    round( $sumaVolAsignado, 3 ),
                    round( $sumaVolAsiETA, 3 ),
                    round( $sumaVolAsiFPE, 3 ),
                    $FecDis->format('d-m-Y'),
                    $codCliente,
                    $nomCliente,
                    $EntComp,
                    $Destino,
                    $PaisDestino,
                    $fpan->format('d-m-Y'),
                    $fpd->format('d-m-Y'),
                    $RoundVentas,
                    $MT,
                    $Nave,
                    $ClaseMaterial,
                    $comstatus
                )
            );
        }
        return $entregasFinal;
    }

    /**
     * @Route("/pedido", name="arauco_pedido_index")
     * @Template("AraucoBaseBundle:Pedido:index.html.twig")
     */
    public function importAction ()
    {
        for ($i = 0; $i < 8; $i++) {

            $dateconvert = PedidosController::dateconvert($i);
            $start_week = $dateconvert['start_week'];
            $end_week   = $dateconvert['end_week'];

            $em = $this->getDoctrine()->getManager();

            $query = $em->createQuery("
                SELECT
                    SUM( P.VolPedido ) as M3
                FROM
                    AraucoCSVBundle:Pedidos P
                WHERE
                    P.Eta >='".$start_week."'
                    AND P.Eta <='".$end_week."'
                    AND P.StatusComplete = 'CPU'
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantEntregasCompletasEnPuerto[$i] = round($query->getSingleScalarResult()/1000, 3);

            if(!isset($cantEntregasCompletasEnPuerto[$i]))
                $cantEntregasCompletasEnPuerto[$i] = 0;

            $query2 = $em->createQuery("
                SELECT
                    SUM( P.VolPedido ) as M3
                FROM
                    AraucoCSVBundle:Pedidos P
                WHERE
                    P.Eta >='".$start_week."'
                    AND P.Eta <='".$end_week."'
                    AND P.StatusComplete = 'CPL'
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantEntregasCompletasEnPlanta[$i] = round($query2->getSingleScalarResult()/1000,3);

            if(!isset($cantEntregasCompletasEnPlanta[$i]))
                $cantEntregasCompletasEnPlanta[$i] = 0;

            $query3 = $em->createQuery("
                SELECT
                    SUM( P.VolPedido ) as M3
                FROM
                    AraucoCSVBundle:Pedidos P
                WHERE
                    P.Eta >='".$start_week."'
                    AND P.Eta <='".$end_week."'
                    AND P.StatusComplete = 'NO'
                    AND P.PED_COMPLETABLE_ETA = TRUE
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantEntregasCompletablesETA[$i] = round($query3->getSingleScalarResult()/1000,3);

            if(!isset($cantEntregasCompletablesETA[$i]))
                $cantEntregasCompletablesETA[$i] = 0;

            $query31 = $em->createQuery("
                SELECT
                    SUM( P.VolPedido ) as M3
                FROM
                    AraucoCSVBundle:Pedidos P
                WHERE
                    P.Eta >='".$start_week."'
                    AND P.Eta <='".$end_week."'
                    AND P.StatusComplete = 'NO'
                    AND P.PED_COMPLETABLE_FPE = TRUE
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantEntregasCompletablesFPE[$i] = round($query31->getSingleScalarResult()/1000,3);

            if(!isset($cantEntregasCompletablesFPE[$i]))
                $cantEntregasCompletablesFPE[$i] = 0;

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
                    AND P.PED_COMPLETABLE_ETA = FALSE
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantCompletadeEntregasIncompletasETA[$i] = round($query41->getSingleScalarResult()/1000,3);

            if(!isset($cantCompletadeEntregasIncompletasETA[$i]))
                $cantCompletadeEntregasIncompletasETA[$i] = 0;

            $query42 = $em->createQuery("
                SELECT
                    SUM( P.VolPedido ) as M3
                FROM
                    AraucoCSVBundle:Pedidos P
                WHERE
                    P.Eta >='".$start_week."'
                    AND P.Eta <='".$end_week."'
                    AND P.StatusComplete = 'NO'
                    AND P.PED_COMPLETABLE_ETA = FALSE
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantIncompletadeEntregasIncompletasETA[$i] = round($query42->getSingleScalarResult()/1000,3);

            if(!isset($cantIncompletadeEntregasIncompletasETA[$i]))
                $cantIncompletadeEntregasIncompletasETA[$i] = 0;
             else
                $cantIncompletadeEntregasIncompletasETA[$i] = $cantIncompletadeEntregasIncompletasETA[$i] - $cantCompletadeEntregasIncompletasETA[$i];

            $query51 = $em->createQuery("
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
            $cantCompletadeEntregasIncompletasFPE[$i] = round($query51->getSingleScalarResult()/1000,3);

            if(!isset($cantCompletadeEntregasIncompletasFPE[$i]))
                $cantCompletadeEntregasIncompletasFPE[$i] = 0;

            $query52 = $em->createQuery("
                SELECT
                    SUM( P.VolPedido ) as M3
                FROM
                    AraucoCSVBundle:Pedidos P
                WHERE
                    P.Eta >='".$start_week."'
                    AND P.Eta <='".$end_week."'
                    AND P.StatusComplete = 'NO'
                    AND P.PED_COMPLETABLE_FPE = FALSE
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantIncompletadeEntregasIncompletasFPE[$i] = round($query52->getSingleScalarResult()/1000,3);

            if(!isset($cantIncompletadeEntregasIncompletasFPE[$i]))
                $cantIncompletadeEntregasIncompletasFPE[$i] = 0;
            else
                $cantIncompletadeEntregasIncompletasFPE[$i] = $cantIncompletadeEntregasIncompletasFPE[$i] - $cantCompletadeEntregasIncompletasFPE[$i];
        }

        return array(
            'cantEntregasCompletasEnPuerto' => $cantEntregasCompletasEnPuerto,
            'cantEntregasCompletasEnPlanta' => $cantEntregasCompletasEnPlanta,
            'cantEntregasCompletablesETA' => $cantEntregasCompletablesETA,
            'cantEntregasCompletablesFPE' => $cantEntregasCompletablesFPE,
            'cantCompletadeEntregasIncompletasETA' => $cantCompletadeEntregasIncompletasETA,
            'cantCompletadeEntregasIncompletasFPE' => $cantCompletadeEntregasIncompletasFPE,
            'cantIncompletadeEntregasIncompletasETA' => $cantIncompletadeEntregasIncompletasETA,
            'cantIncompletadeEntregasIncompletasFPE' => $cantIncompletadeEntregasIncompletasFPE
            );
    }
     /**
     * @Route("/pedido/pasa", name="arauco_pedido_index_pasa")
     * @Template("AraucoBaseBundle:Pedido:pasa.html.twig")
     */
    public function importpasaAction ()
    {
        for ($i = 0; $i < 8; $i++) {
            $dateconvert = PedidosController::dateconvert($i);
            $start_week = $dateconvert['start_week'];
            $end_week   = $dateconvert['end_week'];

            $em = $this->getDoctrine()->getManager();

            $query = $em->createQuery("
                SELECT
                    SUM( P.VolPedido ) as M3
                FROM
                    AraucoCSVBundle:Pedidos P
                WHERE
                    P.Eta >='".$start_week."'
                    AND P.Eta <='".$end_week."'
                    AND P.StatusComplete = 'CPU'
                    AND (P.OrgVenta = 3000 OR P.OrgVenta = 3100)
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantEntregasCompletasEnPuerto[$i] = round($query->getSingleScalarResult()/1000,3);

            if(!isset($cantEntregasCompletasEnPuerto[$i]))
                $cantEntregasCompletasEnPuerto[$i] = 0;

            $query2 = $em->createQuery("
                SELECT
                    SUM( P.VolPedido ) as M3
                FROM
                    AraucoCSVBundle:Pedidos P
                WHERE
                    P.Eta >='".$start_week."'
                    AND P.Eta <='".$end_week."'
                    AND P.StatusComplete = 'CPL'
                    AND (P.OrgVenta = 3000 OR P.OrgVenta = 3100)
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantEntregasCompletasEnPlanta[$i] = round($query2->getSingleScalarResult()/1000,3);

            if(!isset($cantEntregasCompletasEnPlanta[$i]))
                $cantEntregasCompletasEnPlanta[$i] = 0;

            $query3 = $em->createQuery("
                SELECT
                    SUM( P.VolPedido ) as M3
                FROM
                    AraucoCSVBundle:Pedidos P
                WHERE
                    P.Eta >='".$start_week."'
                    AND P.Eta <='".$end_week."'
                    AND P.StatusComplete = 'NO'
                    AND P.PED_COMPLETABLE_ETA = TRUE
                    AND (P.OrgVenta = 3000 OR P.OrgVenta = 3100)
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantEntregasCompletablesETA[$i] = round($query3->getSingleScalarResult()/1000,3);

            if(!isset($cantEntregasCompletablesETA[$i]))
                $cantEntregasCompletablesETA[$i] = 0;

            $query31 = $em->createQuery("
                SELECT
                    SUM( P.VolPedido ) as M3
                FROM
                    AraucoCSVBundle:Pedidos P
                WHERE
                    P.Eta >='".$start_week."'
                    AND P.Eta <='".$end_week."'
                    AND P.StatusComplete = 'NO'
                    AND P.PED_COMPLETABLE_FPE = TRUE
                    AND (P.OrgVenta = 3000 OR P.OrgVenta = 3100)
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantEntregasCompletablesFPE[$i] = round($query31->getSingleScalarResult()/1000,3);

            if(!isset($cantEntregasCompletablesFPE[$i]))
                $cantEntregasCompletablesFPE[$i] = 0;

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
                    AND P.PED_COMPLETABLE_ETA = FALSE
                    AND (P.OrgVenta = 3000 OR P.OrgVenta = 3100)
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantCompletadeEntregasIncompletasETA[$i] = round($query41->getSingleScalarResult()/1000,3);

            if(!isset($cantCompletadeEntregasIncompletasETA[$i]))
                $cantCompletadeEntregasIncompletasETA[$i] = 0;

            $query42 = $em->createQuery("
                SELECT
                    SUM( P.VolPedido ) as M3
                FROM
                    AraucoCSVBundle:Pedidos P
                WHERE
                    P.Eta >='".$start_week."'
                    AND P.Eta <='".$end_week."'
                    AND P.StatusComplete = 'NO'
                    AND P.PED_COMPLETABLE_ETA = FALSE
                    AND (P.OrgVenta = 3000 OR P.OrgVenta = 3100)
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantIncompletadeEntregasIncompletasETA[$i] = round($query42->getSingleScalarResult()/1000,3);

            if(!isset($cantIncompletadeEntregasIncompletasETA[$i]))
                $cantIncompletadeEntregasIncompletasETA[$i] = 0;
             else
                $cantIncompletadeEntregasIncompletasETA[$i] = $cantIncompletadeEntregasIncompletasETA[$i] - $cantCompletadeEntregasIncompletasETA[$i];

            $query51 = $em->createQuery("
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
                    AND (P.OrgVenta = 3000 OR P.OrgVenta = 3100)
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantCompletadeEntregasIncompletasFPE[$i] = round($query51->getSingleScalarResult()/1000,3);

            if(!isset($cantCompletadeEntregasIncompletasFPE[$i]))
                $cantCompletadeEntregasIncompletasFPE[$i] = 0;

            $query52 = $em->createQuery("
                SELECT
                    SUM( P.VolPedido ) as M3
                FROM
                    AraucoCSVBundle:Pedidos P
                WHERE
                    P.Eta >='".$start_week."'
                    AND P.Eta <='".$end_week."'
                    AND P.StatusComplete = 'NO'
                    AND P.PED_COMPLETABLE_FPE = FALSE
                    AND (P.OrgVenta = 3000 OR P.OrgVenta = 3100)
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantIncompletadeEntregasIncompletasFPE[$i] = round($query52->getSingleScalarResult()/1000,3);

            if(!isset($cantIncompletadeEntregasIncompletasFPE[$i]))
                $cantIncompletadeEntregasIncompletasFPE[$i] = 0;
            else
                $cantIncompletadeEntregasIncompletasFPE[$i] = $cantIncompletadeEntregasIncompletasFPE[$i] - $cantCompletadeEntregasIncompletasFPE[$i];
        }

        return array(
            'cantEntregasCompletasEnPuerto' => $cantEntregasCompletasEnPuerto,
            'cantEntregasCompletasEnPlanta' => $cantEntregasCompletasEnPlanta,
            'cantEntregasCompletablesETA' => $cantEntregasCompletablesETA,
            'cantEntregasCompletablesFPE' => $cantEntregasCompletablesFPE,
            'cantCompletadeEntregasIncompletasETA' => $cantCompletadeEntregasIncompletasETA,
            'cantCompletadeEntregasIncompletasFPE' => $cantCompletadeEntregasIncompletasFPE,
            'cantIncompletadeEntregasIncompletasETA' => $cantIncompletadeEntregasIncompletasETA,
            'cantIncompletadeEntregasIncompletasFPE' => $cantIncompletadeEntregasIncompletasFPE
            );

    }

     /**
     * @Route("/pedido/aasa", name="arauco_pedido_index_aasa")
     * @Template("AraucoBaseBundle:Pedido:aasa.html.twig")
     */
    public function importaasaAction ()
    {
        for ($i = 0; $i < 8; $i++) {
            $dateconvert = PedidosController::dateconvert($i);
            $start_week = $dateconvert['start_week'];
            $end_week   = $dateconvert['end_week'];

            $em = $this->getDoctrine()->getManager();

            $query = $em->createQuery("
                SELECT
                    SUM( P.VolPedido ) as M3
                FROM
                    AraucoCSVBundle:Pedidos P
                WHERE
                    P.Eta >='".$start_week."'
                    AND P.Eta <='".$end_week."'
                    AND P.StatusComplete = 'CPU'
                    AND P.OrgVenta = 1000
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantEntregasCompletasEnPuerto[$i] = round($query->getSingleScalarResult()/1000,3);

            if(!isset($cantEntregasCompletasEnPuerto[$i]))
                $cantEntregasCompletasEnPuerto[$i] = 0;

            $query2 = $em->createQuery("
                SELECT
                    SUM( P.VolPedido ) as M3
                FROM
                    AraucoCSVBundle:Pedidos P
                WHERE
                    P.Eta >='".$start_week."'
                    AND P.Eta <='".$end_week."'
                    AND P.StatusComplete = 'CPL'
                    AND P.OrgVenta = 1000
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantEntregasCompletasEnPlanta[$i] = round($query2->getSingleScalarResult()/1000,3);

            if(!isset($cantEntregasCompletasEnPlanta[$i]))
                $cantEntregasCompletasEnPlanta[$i] = 0;

            $query3 = $em->createQuery("
                SELECT
                    SUM( P.VolPedido ) as M3
                FROM
                    AraucoCSVBundle:Pedidos P
                WHERE
                    P.Eta >='".$start_week."'
                    AND P.Eta <='".$end_week."'
                    AND P.StatusComplete = 'NO'
                    AND P.PED_COMPLETABLE_ETA = TRUE
                    AND P.OrgVenta = 1000
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantEntregasCompletablesETA[$i] = round($query3->getSingleScalarResult()/1000,3);

            if(!isset($cantEntregasCompletablesETA[$i]))
                $cantEntregasCompletablesETA[$i] = 0;

            $query31 = $em->createQuery("
                SELECT
                    SUM( P.VolPedido ) as M3
                FROM
                    AraucoCSVBundle:Pedidos P
                WHERE
                    P.Eta >='".$start_week."'
                    AND P.Eta <='".$end_week."'
                    AND P.StatusComplete = 'NO'
                    AND P.PED_COMPLETABLE_FPE = TRUE
                    AND P.OrgVenta = 1000
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantEntregasCompletablesFPE[$i] = round($query31->getSingleScalarResult()/1000,3);

            if(!isset($cantEntregasCompletablesFPE[$i]))
                $cantEntregasCompletablesFPE[$i] = 0;

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
                    AND P.PED_COMPLETABLE_ETA = FALSE
                    AND P.OrgVenta = 1000
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantCompletadeEntregasIncompletasETA[$i] = round($query41->getSingleScalarResult()/1000,3);

            if(!isset($cantCompletadeEntregasIncompletasETA[$i]))
                $cantCompletadeEntregasIncompletasETA[$i] = 0;

            $query42 = $em->createQuery("
                SELECT
                    SUM( P.VolPedido ) as M3
                FROM
                    AraucoCSVBundle:Pedidos P
                WHERE
                    P.Eta >='".$start_week."'
                    AND P.Eta <='".$end_week."'
                    AND P.StatusComplete = 'NO'
                    AND P.PED_COMPLETABLE_ETA = FALSE
                    AND P.OrgVenta = 1000
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantIncompletadeEntregasIncompletasETA[$i] = round($query42->getSingleScalarResult()/1000,3);

            if(!isset($cantIncompletadeEntregasIncompletasETA[$i]))
                $cantIncompletadeEntregasIncompletasETA[$i] = 0;
             else
                $cantIncompletadeEntregasIncompletasETA[$i] = $cantIncompletadeEntregasIncompletasETA[$i] - $cantCompletadeEntregasIncompletasETA[$i];

            $query51 = $em->createQuery("
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
                    AND P.OrgVenta = 1000
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantCompletadeEntregasIncompletasFPE[$i] = round($query51->getSingleScalarResult()/1000,3);

            if(!isset($cantCompletadeEntregasIncompletasFPE[$i]))
                $cantCompletadeEntregasIncompletasFPE[$i] = 0;

            $query52 = $em->createQuery("
                SELECT
                    SUM( P.VolPedido ) as M3
                FROM
                    AraucoCSVBundle:Pedidos P
                WHERE
                    P.Eta >='".$start_week."'
                    AND P.Eta <='".$end_week."'
                    AND P.StatusComplete = 'NO'
                    AND P.PED_COMPLETABLE_FPE = FALSE
                    AND P.OrgVenta = 1000
                    AND P.StatusMovimientodeMcia = 'A'
                    ");

            $cantIncompletadeEntregasIncompletasFPE[$i] = round($query52->getSingleScalarResult()/1000,3);

            if(!isset($cantIncompletadeEntregasIncompletasFPE[$i]))
                $cantIncompletadeEntregasIncompletasFPE[$i] = 0;
            else
                $cantIncompletadeEntregasIncompletasFPE[$i] = $cantIncompletadeEntregasIncompletasFPE[$i] - $cantCompletadeEntregasIncompletasFPE[$i];
        }

        return array(
            'cantEntregasCompletasEnPuerto' => $cantEntregasCompletasEnPuerto,
            'cantEntregasCompletasEnPlanta' => $cantEntregasCompletasEnPlanta,
            'cantEntregasCompletablesETA' => $cantEntregasCompletablesETA,
            'cantEntregasCompletablesFPE' => $cantEntregasCompletablesFPE,
            'cantCompletadeEntregasIncompletasETA' => $cantCompletadeEntregasIncompletasETA,
            'cantCompletadeEntregasIncompletasFPE' => $cantCompletadeEntregasIncompletasFPE,
            'cantIncompletadeEntregasIncompletasETA' => $cantIncompletadeEntregasIncompletasETA,
            'cantIncompletadeEntregasIncompletasFPE' => $cantIncompletadeEntregasIncompletasFPE
            );
    }

    /**
     * @Route("/pedido/comcpu/{week}", name="arauco_pedido_extend_com_cpu")
     * @Template("AraucoBaseBundle:Pedido:extendCPU.html.twig")
     */
    public function extendcomcpuAction ($week)
    {
        $dateconvert    = PedidosController::dateconvert($week);
        $start_week     = $dateconvert['start_week'];
        $end_week       = $dateconvert['end_week'];
        $sWeek          = $dateconvert['sWeek'];
        $eWeek          = $dateconvert['eWeek'];

        $status = "CPU";
        $em = $this->getDoctrine()->getManager();

        $EntregasAsignadas = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosAsig($start_week, $end_week, $status);
        $EntregasETA = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosETA($start_week, $end_week, $status);
        $EntregasFPE = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosFPE($start_week, $end_week, $status);

        $entregasFinal = PedidosController::sortComplete ($EntregasAsignadas, $EntregasETA, $EntregasFPE, "CPU");

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
        $dateconvert    = PedidosController::dateconvert($week);
        $start_week     = $dateconvert['start_week'];
        $end_week       = $dateconvert['end_week'];
        $sWeek          = $dateconvert['sWeek'];
        $eWeek          = $dateconvert['eWeek'];

        $status = "CPL";
        $em = $this->getDoctrine()->getManager();

        $EntregasAsignadas = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosAsig($start_week, $end_week, $status);
        $EntregasETA = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosETA($start_week, $end_week, $status);
        $EntregasFPE = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosFPE($start_week, $end_week, $status);

        $entregasFinal = PedidosController::sortComplete ($EntregasAsignadas, $EntregasETA, $EntregasFPE, "CPL");

        return array(
            'Entregas' => $entregasFinal,
            'sWeek' => $sWeek,
            'eWeek' => $eWeek,
            'week' => $week
        );
    }

    /**
     * @Route("/pedido/complet/eta/{week}", name="arauco_pedido_extend_complet_eta")
     * @Template("AraucoBaseBundle:Pedido:extendComplETA.html.twig")
     */
    public function extendcompletaAction ($week)
    {
        $dateconvert    = PedidosController::dateconvert($week);
        $start_week     = $dateconvert['start_week'];
        $end_week       = $dateconvert['end_week'];
        $sWeek          = $dateconvert['sWeek'];
        $eWeek          = $dateconvert['eWeek'];

        $status = "NO";
        $completable = TRUE;

        $em = $this->getDoctrine()->getManager();

        $Entregas = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosAsigIncETAList($start_week, $end_week, $status, $completable);
        $EntregasM3 = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosAsigIncETASumM3($start_week, $end_week, $status, $completable);
        $EntregasETA = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosETAIncETA($start_week, $end_week, $status, $completable);
        $EntregasFPE = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosFPEIncETA($start_week, $end_week, $status, $completable);

        $entregasFinal = PedidosController::sortIncomplete ($Entregas, $EntregasM3, $EntregasETA, $EntregasFPE, "ComETA");

        return array(
            'Entregas' => $entregasFinal,
            'sWeek' => $sWeek,
            'eWeek' => $eWeek,
            'week' => $week);
    }

    /**
     * @Route("/pedido/inc/eta/{week}", name="arauco_pedido_extend_inc_eta")
     * @Template("AraucoBaseBundle:Pedido:extendIncETA.html.twig")
     */
    public function extendincetaAction ($week)
    {
        $dateconvert    = PedidosController::dateconvert($week);
        $start_week     = $dateconvert['start_week'];
        $end_week       = $dateconvert['end_week'];
        $sWeek          = $dateconvert['sWeek'];
        $eWeek          = $dateconvert['eWeek'];

        $status = "NO";
        $completable = FALSE;
        $em = $this->getDoctrine()->getManager();

        $Entregas = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosAsigIncETAList($start_week, $end_week, $status, $completable);
        $EntregasM3 = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosAsigIncETASumM3($start_week, $end_week, $status, $completable);
        $EntregasETA = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosETAIncETA($start_week, $end_week, $status, $completable);
        $EntregasFPE = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosFPEIncETA($start_week, $end_week, $status, $completable);

        $entregasFinal = PedidosController::sortIncomplete ($Entregas, $EntregasM3, $EntregasETA, $EntregasFPE, "IncETA");

        return array(
            'Entregas' => $entregasFinal,
            'sWeek' => $sWeek,
            'eWeek' => $eWeek,
            'week' => $week);
    }

    /**
     * @Route("/pedido/complet/fpe/{week}", name="arauco_pedido_extend_complet_fpe")
     * @Template("AraucoBaseBundle:Pedido:extendComplFPE.html.twig")
     */
    public function extendcomplfpeAction ($week)
    {
        $dateconvert    = PedidosController::dateconvert($week);
        $start_week     = $dateconvert['start_week'];
        $end_week       = $dateconvert['end_week'];
        $sWeek          = $dateconvert['sWeek'];
        $eWeek          = $dateconvert['eWeek'];

        $status = "NO";
        $completable = TRUE;
        $em = $this->getDoctrine()->getManager();

        $Entregas = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosAsigIncFPEList($start_week, $end_week, $status, $completable);
        $EntregasM3 = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosAsigIncFPESumM3($start_week, $end_week, $status, $completable);
        $EntregasETA = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosETAIncFPE($start_week, $end_week, $status, $completable);
        $EntregasFPE = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosFPEIncFPE($start_week, $end_week, $status, $completable);

        $entregasFinal = PedidosController::sortIncomplete ($Entregas, $EntregasM3, $EntregasETA, $EntregasFPE, "ComFPE");

        return array(
            'Entregas' => $entregasFinal,
            'sWeek' => $sWeek,
            'eWeek' => $eWeek,
            'week' => $week);
    }

    /**
     * @Route("/pedido/inc/fpe/{week}", name="arauco_pedido_extend_inc_fpe")
     * @Template("AraucoBaseBundle:Pedido:extendIncFPE.html.twig")
     */
    public function extendincfpeAction ($week)
    {
        $dateconvert    = PedidosController::dateconvert($week);
        $start_week     = $dateconvert['start_week'];
        $end_week       = $dateconvert['end_week'];
        $sWeek          = $dateconvert['sWeek'];
        $eWeek          = $dateconvert['eWeek'];

        $status = "NO";
        $completable = FALSE;
        $em = $this->getDoctrine()->getManager();

        $Entregas = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosAsigIncFPEList($start_week, $end_week, $status, $completable);
        $EntregasM3 = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosAsigIncFPESumM3($start_week, $end_week, $status, $completable);
        $EntregasETA = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosETAIncFPE($start_week, $end_week, $status, $completable);
        $EntregasFPE = $em->getRepository('AraucoCSVBundle:Pedidos')->findPedidosFPEIncFPE($start_week, $end_week, $status, $completable);

        $entregasFinal = PedidosController::sortIncomplete ($Entregas, $EntregasM3, $EntregasETA, $EntregasFPE, "IncFPE");

        return array(
            'Entregas' => $entregasFinal,
            'sWeek' => $sWeek,
            'eWeek' => $eWeek,
            'week' => $week);
    }

    /**
     * @Route("/pedido/docentrega/{id}", name="arauco_pedido_docentrega")
     * @Template("AraucoBaseBundle:Pedido:extendDocEntrega.html.twig")
     */
    public function docentregainfoAction ($id)
    {
        $em = $this->getDoctrine()->getManager();

        $generalinfoQuery = $em->createQuery("
            SELECT
                P.DocEntrega,
                P.PosPedido,
                P.CodCliente,
                P.NomCliente,
                P.EntComp,
                P.Material,
                P.DescripcionMaterial,
                P.VolPedido,
                P.PaisDestino,
                P.Destino,
                P.Eta,
                P.FPE,
                P.FPAN,
                P.FPD,
                P.FecDis,
                P.RoundVentas,
                P.MT,
                P.Nave,
                P.ClaseMaterial
            FROM
                AraucoCSVBundle:Pedidos P
            WHERE
                P.DocEntrega=".$id."
            GROUP BY
                P.DocEntrega,
                P.PosPedido
            ORDER BY
                P.DocEntrega,
                P.PosPedido")->getResult();

        $sumM3AsigQuery = $em->createQuery("
            SELECT
                P.DocEntrega,
                P.PosPedido,
                SUM ( S.M3 ) as M3
            FROM
                AraucoCSVBundle:Pedidos P,
                AraucoCSVBundle:Stock S
            WHERE
                P.DocEntrega = S.Nro_Entrega
                AND P.PosPedido = S.Pos_Entrega
                AND P.DocEntrega=".$id."
            GROUP BY
                P.DocEntrega,
                P.PosPedido
            ORDER BY
                P.DocEntrega,
                P.PosPedido")->getResult();

        $sumM3ETAQuery = $em->createQuery("
            SELECT
                P.DocEntrega,
                P.PosPedido,
                SUM ( S.M3 ) as M3
            FROM
                AraucoCSVBundle:Pedidos P,
                AraucoCSVBundle:Stock S
            WHERE
                P.DocEntrega = S.STO_DOCENTREGA_ASI_ETA
                AND P.PosPedido = S.STO_POSPEDIDO_ASI_ETA
                AND P.DocEntrega=".$id."
            GROUP BY
                P.DocEntrega,
                P.PosPedido
            ORDER BY
                P.DocEntrega,
                P.PosPedido")->getResult();

        $sumM3FPEQuery = $em->createQuery("
            SELECT
                P.DocEntrega,
                P.PosPedido,
                SUM ( S.M3 ) as M3
            FROM
                AraucoCSVBundle:Pedidos P,
                AraucoCSVBundle:Stock S
            WHERE
                P.DocEntrega = S.STO_DOCENTREGA_ASI_FPE
                AND P.PosPedido = S.STO_POSPEDIDO_ASI_FPE
                AND P.DocEntrega=".$id."
            GROUP BY
                P.DocEntrega,
                P.PosPedido
            ORDER BY
                P.DocEntrega,
                P.PosPedido")->getResult();

        $arrayDocEntrega = array();

        foreach ( $generalinfoQuery as $Posicion ) {

            $docEntrega = $Posicion['DocEntrega'];
            $posPedido = $Posicion['PosPedido'];
            $codCliente = $Posicion['CodCliente'];
            $nomCliente = $Posicion['NomCliente'];
            $Material = $Posicion['Material'];
            $DescripcionMaterial = $Posicion['DescripcionMaterial'];
            $VolPedido = $Posicion['VolPedido'];
            $PaisDestino = $Posicion['PaisDestino'];
            $Destino = $Posicion['Destino'];
            $Eta = $Posicion['Eta'];
            $FPE = $Posicion['FPE'];
            $FPAN = $Posicion['FPAN'];
            $FPD = $Posicion['FPD'];
            $FecDis = $Posicion['FecDis'];
            $RoundVentas = $Posicion['RoundVentas'];
            $MT = $Posicion['MT'];
            $EntComp = $Posicion['EntComp'];
            $Nave = $Posicion['Nave'];
            $ClaseMaterial = $Posicion['ClaseMaterial'];

            $sumaVolAsignado = 0;
            $sumaVolAsiETA = 0;
            $sumaVolAsiFPE = 0;

            foreach ( $sumM3AsigQuery as $item ) {

                if ( $docEntrega == $item['DocEntrega']
                    && $posPedido == $item['PosPedido'] ) {
                    $sumaVolAsignado = $item['M3'];
                    break;
                }

                if ($docEntrega < $item['DocEntrega'])
                    break;

            }

            foreach ( $sumM3ETAQuery as $item ) {

                if ( $docEntrega == $item['DocEntrega']
                    && $posPedido == $item['PosPedido'] ) {
                    $sumaVolAsiETA = $item['M3'];
                    break;
                }

                if ($docEntrega < $item['DocEntrega'])
                    break;

            }

            foreach ( $sumM3FPEQuery as $item ) {

                if ( $docEntrega == $item['DocEntrega']
                    && $posPedido == $item['PosPedido'] ) {
                    $sumaVolAsiFPE = $item['M3'];
                    break;
                }

                if ($docEntrega < $item['DocEntrega'])
                    break;

            }

            array_push(
                $arrayDocEntrega, array(
                    $posPedido,
                    $FPE->format('d-m-Y'),
                    $Eta->format('d-m-Y'),
                    $FecDis->format('d-m-Y'),
                    $Material,
                    $DescripcionMaterial,
                    $VolPedido,
                    round( $sumaVolAsignado, 3 ),
                    round( $sumaVolAsiETA, 3 ),
                    round( $sumaVolAsiFPE, 3 ),
                    $codCliente,
                    $nomCliente,
                    $EntComp,
                    $Destino,
                    $PaisDestino,
                    $FPAN->format('d-m-Y'),
                    $FPD->format('d-m-Y'),
                    $RoundVentas->format('Y-m'),
                    $MT,
                    $Nave,
                    $ClaseMaterial,
                    $docEntrega
                )
            );

        }

        return array('arrayDocEntrega' => $arrayDocEntrega, 'id' => $id);
    }

    /**
     * @Route("/pedido/docentrega/{id}/csv", name="arauco_pedido_docentrega_csv")
     * @Template("AraucoBaseBundle:Pedido:extendDocEntrega.html.twig")
     */
    public function docentregainfocsvAction ($id)
    {
        $filename = "DocEntrega-".$id." ".date("Y_m_d_His").".csv";

        $arrayDocEntrega = PedidosController::docentregainfoAction($id)['arrayDocEntrega'];

        $response = $this->render('AraucoBaseBundle:Pedido:docentregaCsv.html.twig', array('data' => $arrayDocEntrega ));

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);

        return $response;
    }

    /**
     * @Route("/pedido/{week}/comcpu/csv", name="arauco_pedido_extendcsv_comcpu")
     */
    public function extendcsvcomcpuAction ($week)
    {
        $dateconvert    = PedidosController::dateconvert($week);
        $start_week     = $dateconvert['start_week'];
        $end_week       = $dateconvert['end_week'];

        $filename = "PedidosCPU_".$start_week."_".$end_week."_".date("Y_m_d_His").".csv";

        $entregasFinal = PedidosController::extendcomcpuAction($week)['Entregas'];

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
        $dateconvert    = PedidosController::dateconvert($week);
        $start_week     = $dateconvert['start_week'];
        $end_week       = $dateconvert['end_week'];

        $filename = "PedidosCPL_".$start_week."_".$end_week."_".date("Y_m_d_His").".csv";

        $entregasFinal = PedidosController::extendcomcplAction($week)['Entregas'];

        $response = $this->render('AraucoBaseBundle:Pedido:pedidosCsv.html.twig', array('data' => $entregasFinal ));

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);

        return $response;
    }

    /**
     * @Route("/pedido/complet/eta/{week}/csv", name="arauco_pedido_extend_complet_eta_csv")
     */
    public function extendcompletacsvAction ($week)
    {
        $dateconvert    = PedidosController::dateconvert($week);
        $start_week     = $dateconvert['start_week'];
        $end_week       = $dateconvert['end_week'];

        $filename = "PedidosComplETA_".$start_week."_".$end_week."_".date("Y_m_d_His").".csv";

        $entregasFinal = PedidosController::extendcompletaAction($week)['Entregas'];

        $response = $this->render('AraucoBaseBundle:Pedido:pedidosCsv.html.twig', array('data' => $entregasFinal ));

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);

        return $response;
    }

    /**
     * @Route("/pedido/inc/eta/{week}/csv", name="arauco_pedido_extend_inc_eta_csv")
     */
    public function extendincetacsvAction ($week)
    {
        $dateconvert    = PedidosController::dateconvert($week);
        $start_week     = $dateconvert['start_week'];
        $end_week       = $dateconvert['end_week'];

        $filename = "PedidosIncETA_".$start_week."_".$end_week."_".date("Y_m_d_His").".csv";

        $entregasFinal = PedidosController::extendincetaAction($week)['Entregas'];

        $response = $this->render('AraucoBaseBundle:Pedido:pedidosCsv.html.twig', array('data' => $entregasFinal ));

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);

        return $response;
    }

    /**
     * @Route("/pedido/complet/fpe/{week}/csv", name="arauco_pedido_extend_complet_fpe_csv")
     */
    public function extendcomplfpecsvAction ($week)
    {
        $dateconvert    = PedidosController::dateconvert($week);
        $start_week     = $dateconvert['start_week'];
        $end_week       = $dateconvert['end_week'];

        $filename = "PedidosComplFPE_".$start_week."_".$end_week."_".date("Y_m_d_His").".csv";

        $entregasFinal = PedidosController::extendcomplfpeAction($week)['Entregas'];

        $response = $this->render('AraucoBaseBundle:Pedido:pedidosCsv.html.twig', array('data' => $entregasFinal ));

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);

        return $response;
    }

    /**
     * @Route("/pedido/inc/fpe/{week}/csv", name="arauco_pedido_extend_inc_fpe_csv")
     */
    public function extendincfpecsvAction ($week)
    {
        $dateconvert    = PedidosController::dateconvert($week);
        $start_week     = $dateconvert['start_week'];
        $end_week       = $dateconvert['end_week'];

        $filename = "PedidosIncFPE_".$start_week."_".$end_week."_".date("Y_m_d_His").".csv";

        $entregasFinal = PedidosController::extendincfpeAction($week)['Entregas'];

        $response = $this->render('AraucoBaseBundle:Pedido:pedidosCsv.html.twig', array('data' => $entregasFinal ));

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);

        return $response;
    }

    /**
     * @Route("/pedidos/csv/etageneral", name="arauco_pedido_csv_general_eta")
     */
    public function generalCsvEtaAction(){

        $filename = "ReporteGeneralPedidosETA_".date("Y-m-d_His").".csv";

        $pedidosGeneral = array();

        for ($week = 0; $week < 8; $week++) {
            $dateconvert = PedidosController::dateconvert($week);

            $CPU = PedidosController::extendcomcpuAction($week)['Entregas'];
            $pedidosGeneral = array_merge($pedidosGeneral,$CPU);

            $CPL = PedidosController::extendcomcplAction($week)['Entregas'];
            $pedidosGeneral = array_merge($pedidosGeneral,$CPL);

            $ComETA = PedidosController::extendcompletaAction($week)['Entregas'];
            $pedidosGeneral = array_merge($pedidosGeneral,$ComETA);

            $IncETA = PedidosController::extendincetaAction($week)['Entregas'];
            $pedidosGeneral = array_merge($pedidosGeneral,$IncETA);
        }

        $response = $this->render('AraucoBaseBundle:Pedido:pedidosCsv.html.twig', array('data' => $pedidosGeneral ));

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);

        return $response;
    }

    /**
     * @Route("/pedidos/csv/fpegeneral", name="arauco_pedido_csv_general_fpe")
     */
    public function generalCsvFPEAction(){

        $filename = "ReporteGeneralPedidosFPE_".date("Y-m-d_His").".csv";

        $pedidosGeneral = array();

        for ($week = 0; $week < 8; $week++) {
            $dateconvert = PedidosController::dateconvert($week);

            $CPU = PedidosController::extendcomcpuAction($week)['Entregas'];
            $pedidosGeneral = array_merge($pedidosGeneral,$CPU);

            $CPL = PedidosController::extendcomcplAction($week)['Entregas'];
            $pedidosGeneral = array_merge($pedidosGeneral,$CPL);

            $ComFPE = PedidosController::extendcomplfpeAction($week)['Entregas'];
            $pedidosGeneral = array_merge($pedidosGeneral,$ComFPE);

            $IncFPE = PedidosController::extendincfpeAction($week)['Entregas'];
            $pedidosGeneral = array_merge($pedidosGeneral,$IncFPE);
        }

        $response = $this->render('AraucoBaseBundle:Pedido:pedidosCsv.html.twig', array('data' => $pedidosGeneral ));

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);

        return $response;
    }
}
