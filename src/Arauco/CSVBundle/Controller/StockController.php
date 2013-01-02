<?php

namespace Arauco\CSVBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Arauco\CSVBundle\Entity\Stock;

class StockController extends Controller {

	/**
     * @Route("/stock")
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
