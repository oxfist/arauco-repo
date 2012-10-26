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
        $menu->setNombre('Tallarines');
        $menu->setPrecio('1000.5');
        $menu->setDescripcion('Tallarines muy ricos');
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($menu);
        $em->flush();

        return $this->render( 'AndresTestBundle:Default:crear.html.twig', array('id' => $menu->getId()) );
    }
}
