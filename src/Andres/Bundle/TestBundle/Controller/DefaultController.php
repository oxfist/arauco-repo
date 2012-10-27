<?php

namespace Andres\Bundle\TestBundle\Controller;

use Andres\Bundle\TestBundle\Entity\Menu;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AndresTestBundle:Default:index.html.twig');
    }
    
    public function contentAction()
    {
        return $this->render('AndresTestBundle:Default:content.html.twig');
    }

    public function createAction()
    {
        $menu = new Menu();
        $menu->setNombre('Pollo con papas fritas');
        $menu->setPrecio('4000');
        $menu->setDescripcion('Papitas ricas y muuuy ricas');
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($menu);
        $em->flush();

        return $this->render( 'AndresTestBundle:Default:crear.html.twig',
                              array('id' => $menu->getId()) );
    }

    public function showAction($id) {
        $menu = $this->getDoctrine()
            ->getRepository('AndresTestBundle:Menu')
            ->find($id);
        if (!$menu)
            throw $this->createNotFoundException('No hay menu para el id: ' .$id);
        return $this->render( 'AndresTestBundle:Default:mostrar.html.twig',
                              array('menu' => $menu) );
    }
}
