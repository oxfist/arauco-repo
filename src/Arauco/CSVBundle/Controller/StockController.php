<?php

namespace Arauco\CSVBundle\Controller;

use Arauco\CSVBundle\Entity\Stock;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

ini_set('memory_limit', '-1');

class StockController extends Controller
{
    /**
     * @Route("/stock", name="arauco_stock_index")
     * @Template("AraucoBaseBundle:Stock:index.html.twig")
     */
    public function importAction()
    {

    	$em = $this->getDoctrine()->getManager();
    	$query = $em->createQuery(
                "SELECT COUNT ( S.Lote )
                FROM AraucoCSVBundle:Stock S
                WHERE S.Status = ''"
                );

        $total = $query->getSingleScalarResult ( );

        $query = $em->createQuery(
                "SELECT S.Material, S.Desc_Mat, SUM(S.M3) as tm3
                FROM AraucoCSVBundle:Stock S
                WHERE S.Status = ''
			GROUP BY S.Material"
                );

        $StockSinAsignar = $query->getResult();

        return array('total' => $total,
                     'stocksa' => $StockSinAsignar);
    }

    /**
     * @Route("/stock/{id}", name="arauco_stock_extend")
     * @Template("AraucoBaseBundle:Stock:extend.html.twig")
     */
    public function importextendAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                "SELECT S.Material, S.Desc_Mat, S.Lote, S.Centro, S.Almacen, S.M3
                FROM AraucoCSVBundle:Stock S
                WHERE S.Material = ".$id." AND S.Status <> 'A'"
                );

        $StockSinAsignar = $query->getResult();

        return array('stocksa' => $StockSinAsignar, 'id' => $id);
    }

    /**
     * @Route("/stockcsv", name="arauco_stock_csv")
     */
    public function csvAction() {

    	$em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                "SELECT S.Material, S.Desc_Mat, SUM(S.M3) as tm3
                FROM AraucoCSVBundle:Stock S
                WHERE S.Status = ''
			GROUP BY S.Material"
                );
        $data = $query->getResult();

        $filename = "Stock_CSV".date("Y_m_d_His").".csv";

        $response = $this->render('AraucoBaseBundle:Stock:stockCsv.html.twig', array('data' => $data));

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);

        return $response;
    }

    /**
     * @Route("/stockcsv/{id}", name="arauco_stock_csvextend")
     */
    public function csvextendAction($id) {

    	$em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                "SELECT S.Lote, S.Centro, S.Almacen, S.M3
                FROM AraucoCSVBundle:Stock S
                WHERE S.Material = ".$id." AND S.Status = ''"
                );
        $data = $query->getResult();

        $filename = "Stock_".$id."_".date("Y_m_d_His").".csv";

        $response = $this->render('AraucoBaseBundle:Stock:stockextendCsv.html.twig', array('data' => $data));

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);

        return $response;
    }

    /**
     * @Route("/stock/{docentrega}/{pospedido}/asig", name="arauco_stock_docpos_asig")
     * @Template("AraucoBaseBundle:Stock:docPosAsig.html.twig")
     */
    public function showdocposasigAction($docentrega, $pospedido)
    {
    	$em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            "SELECT
                S.Lote, S.Desc_Mat, S.Centro, S.Almacen, S.M3
             FROM
                AraucoCSVBundle:Stock S
             WHERE
                S.Nro_Entrega = ".$docentrega."
                AND S.Pos_Entrega = ".$pospedido."
            ");

        $stock = $query->getResult();

        return array('stock' => $stock, 'docentrega' => $docentrega, 'pospedido' => $pospedido);
    }

    /**
     * @Route("/stock/{docentrega}/{pospedido}/asig/csv", name="arauco_stock_docpos_asig_csv")
     */
    public function showdocposasigcsvAction($docentrega, $pospedido)
    {
    	$em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            "SELECT
                S.Lote, S.Desc_Mat, S.Centro, S.Almacen, S.M3
             FROM
                AraucoCSVBundle:Stock S
             WHERE
                S.Nro_Entrega = ".$docentrega."
                AND S.Pos_Entrega = ".$pospedido."
            ");
        $data = $query->getResult();

        $filename = "StockAsig_".$docentrega."_".$pospedido."_".date("Y_m_d_His").".csv";

        $response = $this->render('AraucoBaseBundle:Stock:stockextendCsv.html.twig', array('data' => $data));

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);

        return $response;

    }

    /**
     * @Route("/stock/{docentrega}/{pospedido}/eta", name="arauco_stock_docpos_eta")
     * @Template("AraucoBaseBundle:Stock:docPosETA.html.twig")
     */
    public function showdocposetaAction($docentrega, $pospedido)
    {
    	$em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            "SELECT
                S.Lote, S.Desc_Mat, S.Centro, S.Almacen, S.M3
             FROM
                AraucoCSVBundle:Stock S
             WHERE
                S.STO_DOCENTREGA_ASI_ETA = ".$docentrega."
                AND S.STO_POSPEDIDO_ASI_ETA = ".$pospedido."
            ");

        $stock = $query->getResult();

        return array('stock' => $stock, 'docentrega' => $docentrega, 'pospedido' => $pospedido);
    }

    /**
     * @Route("/stock/{docentrega}/{pospedido}/eta/csv", name="arauco_stock_docpos_eta_csv")
     */
    public function showdocposetacsvAction($docentrega, $pospedido)
    {
    	$em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            "SELECT
                S.Lote, S.Desc_Mat, S.Centro, S.Almacen, S.M3
             FROM
                AraucoCSVBundle:Stock S
             WHERE
                S.STO_DOCENTREGA_ASI_ETA = ".$docentrega."
                AND S.STO_POSPEDIDO_ASI_ETA = ".$pospedido."
            ");

        $data = $query->getResult();

        $filename = "StockETA_".$docentrega."_".$pospedido."_".date("Y_m_d_His").".csv";

        $response = $this->render('AraucoBaseBundle:Stock:stockextendCsv.html.twig', array('data' => $data));

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);

        return $response;
    }

    /**
     * @Route("/stock/{docentrega}/{pospedido}/fpe", name="arauco_stock_docpos_fpe")
     * @Template("AraucoBaseBundle:Stock:docPosFPE.html.twig")
     */
    public function showdocposfpeAction($docentrega, $pospedido)
    {
    	$em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            "SELECT
                S.Lote, S.Desc_Mat, S.Centro, S.Almacen, S.M3
             FROM
                AraucoCSVBundle:Stock S
             WHERE
                S.STO_DOCENTREGA_ASI_FPE = ".$docentrega."
                AND S.STO_POSPEDIDO_ASI_FPE = ".$pospedido."
            ");

        $stock = $query->getResult();

        return array('stock' => $stock, 'docentrega' => $docentrega, 'pospedido' => $pospedido);
    }

    /**
     * @Route("/stock/{docentrega}/{pospedido}/fpe/csv", name="arauco_stock_docpos_fpe_csv")
     */
    public function showdocposfpecsvAction($docentrega, $pospedido)
    {
    	$em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            "SELECT
                S.Lote, S.Desc_Mat, S.Centro, S.Almacen, S.M3
             FROM
                AraucoCSVBundle:Stock S
             WHERE
                S.STO_DOCENTREGA_ASI_FPE = ".$docentrega."
                AND S.STO_POSPEDIDO_ASI_FPE = ".$pospedido."
            ");

        $data = $query->getResult();

        $filename = "StockFPE_".$docentrega."_".$pospedido."_".date("Y_m_d_His").".csv";

        $response = $this->render('AraucoBaseBundle:Stock:stockextendCsv.html.twig', array('data' => $data));

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);

        return $response;
    }

}
