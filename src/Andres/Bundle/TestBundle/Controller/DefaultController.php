<?php

namespace Andres\Bundle\TestBundle\Controller;

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
}
