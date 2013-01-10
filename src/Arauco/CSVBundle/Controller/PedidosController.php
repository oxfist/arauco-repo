<?php

namespace Arauco\CSVBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PedidosController extends Controller
{
    /**
     * @Route("/pedido", name="arauco_pedido_index")
     * @Template("AraucoBaseBundle:Pedido:index.html.twig")
     */
    public function importAction ()
    {
    	$em = $this->getDoctrine()->getManager();

        $query = $em->createQuery("SELECT P.DocEntrega, P.PosPedido, S.Material, S.Desc_Mat, P.VolPedido, SUM( S.M3 ) as M3 FROM AraucoCSVBundle:Pedidos P, AraucoCSVBundle:Stock S WHERE P.DocEntrega = S.Nro_Entrega AND P.PosPedido = S.Pos_Entrega AND P.StatusMovimientodeMcia = 'A' GROUP BY P.DocEntrega, P.PosPedido ORDER BY P.DocEntrega");

        $Entregas = $query->getResult();

        return array('Entregas' => $Entregas);
    }
}
