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
     * @Template("AraucoBaseBundle:Stock:index")
     */
	public function importAction ( ) {


		$query = $this -> createQueryBuilder ( )
				-> from ( 'Stock' )
				-> getQuery ( );
		$total = $query -> getSingleScalarResult ( );
		$total = 2;

		return $this->render('AraucoBaseBundle:Stock:index.html.twig',  array( 'total' => $total));

	}

}
