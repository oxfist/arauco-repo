<?php

namespace Arauco\CSVBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Arauco\CSVBundle\Entity\Stock;

class StockController extends Controller
{
    
    /**
     * @Route("/stock", name="arauco_stock_index")
     * @Template("AraucoBaseBundle:Stock:index")
     */
	public function importAction ( ) {


		$total = 2;

		return $this->render('AraucoBaseBundle:Stock:index.html.twig',  array( 'total' => $total));

	}

}
