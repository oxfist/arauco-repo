<?php

namespace Arauco\CSVBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Arauco\CSVBundle\Entity\Stock;

class StockController extends Controller {

	/**
     * @Route("/")
     */
	public function importAction ( ) {

		$reader = new \EasyCSV\Reader ( __DIR__ . '/Data/STOCKHOYPRUEBASINF.txt' , 'r+b', ';' );
		while ( $row = $reader -> getRow ( ) ) {

			print_r ( $row ) ;
			echo '</br>';
			$stock = new Stock ( );
			$stock -> setClase ( $row [ "clase" ] );
			$stock -> setLote ( $row [ "lote" ] );
			$stock -> setFechadeCreacion ( $row [ "fecha_de_creacion" ] );
			$stock -> setUMB ( $row [ "umb" ] );
			$stock -> setCentro ( $row [ "centro" ] );
			$stock -> setDescCentro ( $row [ "desc_centro" ] );
			$stock -> setAlmacen ( $row [ "almacen" ] );
			$stock -> setDescAlm ( $row [ "desc_alm" ] );
			$stock -> setMaterial ( $row [ "material" ] );
			$stock -> setDescMat ( $row [ "desc_mat" ] );
			$stock -> setVolUtil ( $row [ "vol_util" ] );
			$stock -> setVolTran ( $row [ "vol_tran" ] );
			$stock -> setBloqueado ( $row [ "bloqueado" ] );
			$stock -> setJerarquia ( $row [ "jerarquia" ] );
			$stock -> setDescJer ( $row [ "desc_jer" ] );
			$stock -> setGrpoArt ( $row [ "grpo_art" ] );
			$stock -> setDescripGrpoArt ( $row [ "descrip_grpo_art" ] );
			$stock -> setClaseDeValoracion ( $row [ "clasedevaloracion" ] );
			$stock -> setM3 ( $row [ "m3" ] );
			$stock -> setStatus ( $row [ "status" ] );
			$stock -> setNroEntrega ( $row [ "nro_entrega" ] );
			$stock -> setPosEntrega ( $row [ "pos_entrega" ] );
			$stock -> setFchCreacion ( $row [ "fch_creacion" ] );
			$stock -> setDefecto ( $row [ "defecto" ] );
			$stock -> setEspRealMm ( $row [ "esp_real_mm" ] );
			$stock -> setAncRealMm ( $row [ "anc_real_mm" ] );

			$em = $this -> getDoctrine ( ) -> getEntityManager ( );
			$em -> persist ( $stock );
			$em -> flush ( );

		}

		return new Response ( '<html><body> Hello, world! </body></html>' );

	}

}
