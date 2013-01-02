<?php

namespace Arauco\CSVBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Arauco\CSVBundle\Entity\Pedidos;

class PedidosController extends Controller {

	/**
     * @Route("/pedido")
     */
	public function importAction ( ) {

		return new Response ( '<html><body> Hello, world! </body></html>' );

	}

}
