<?php

namespace Andres\Bundle\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        if ( $this->container->get('request')->isXmlHttpRequest() )
            return new Response( "<b>Content loaded with AJAX</b>" );
        return $this->render('AndresTestBundle:Default:index.html.twig');
    }
}
