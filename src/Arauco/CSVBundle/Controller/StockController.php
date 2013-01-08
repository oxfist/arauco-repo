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

}
