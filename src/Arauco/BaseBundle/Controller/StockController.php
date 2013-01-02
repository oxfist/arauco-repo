<?php

namespace Arauco\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class StockController extends Controller
{    
    /**
     * @Route("/stockk", name="arauco_stock_index")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
