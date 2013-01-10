<?php

namespace Arauco\CSVBundle\Controller;

use Arauco\CSVBundle\Entity\Stock;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
                WHERE S.Status <> 'A'"
                );

        $total = $query->getSingleScalarResult ( );

        $query = $em->createQuery(
                "SELECT S.Lote, S.Material, S.Desc_Mat
                FROM AraucoCSVBundle:Stock S
                WHERE S.Status <> 'A'"
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
                "SELECT S.Lote, S.Desc_Mat, S.M3
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
                "SELECT S.Lote, S.Material, S.Desc_Mat
                FROM AraucoCSVBundle:Stock S
                WHERE S.Status <> 'A'"
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
                "SELECT S.Lote, S.M3
                FROM AraucoCSVBundle:Stock S
                WHERE S.Material = ".$id." AND S.Status <> 'A'"
                );
        $data = $query->getResult();

        $filename = "Stock_".$id."_".date("Y_m_d_His").".csv";

        $response = $this->render('AraucoBaseBundle:Stock:stockextendCsv.html.twig', array('data' => $data));

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename='.$filename);

        return $response;
    }

}
