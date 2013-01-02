<?php

namespace Arauco\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class BalanceController extends Controller
{    
    /**
     * @Route("/balance", name="arauco_balance_index")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
