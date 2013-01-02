<?php

namespace Arauco\CSVBundle\Controller;

ini_set('max_execution_time', 300);

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Arauco\CSVBundle\Entity\Pedidos;

class PedidosController extends Controller {

	/**
     * @Route("/pedido")
     */
	public function importAction ( ) {

		$reader = new \EasyCSV\Reader ( __DIR__ . '/Data/Pedidos.csv' , 'r+b' , ';');
		while ( $row = $reader -> getRow ( ) ) {

			$pedido = new Pedidos ( );
			$pedido -> setDocENtrega ( $row [ "doc.entrega" ] );
			$pedido -> setPedido ( $row [ "pedido" ] );
			$pedido -> setPosPedido ( $row [ "pos.pedido" ] );
			$pedido -> setCentroPedido ( $row [ "centropedido" ] );
			$pedido -> setVolPedido ( $row [ "vol.pedido" ] );
			$pedido -> setUM ( $row [ "um" ] );
			$pedido -> setUnitsSolicPed ( $row [ "units.solic.ped" ] );
			$pedido -> setUM2 ( $row [ "um2" ] );
			$pedido -> setCantidadUMV ( $row [ "cantidadumv" ] );
			$pedido -> setUMV ( $row [ "umv" ] );
			$pedido -> setMaterial ( $row [ "material" ] );
			$pedido -> setDescripcionMaterial ( $row [ "descripcionmaterial" ] );
			$pedido -> setCategoria ( $row [ "categoria" ] );
			$pedido -> setFPE ( $row [ "fpe" ] );
			$pedido -> setFPAN ( $row [ "fpan" ] );
			$pedido -> setStatusMovimientodeMcia ( $row [ "statusmovimientodemcia" ] );

			$em = $this -> getDoctrine ( ) -> getEntityManager ( );
			$em -> persist ( $pedido );
			$em -> flush ( );

		}

		return new Response ( '<html><body> Hello, world! </body></html>' );

	}

}
