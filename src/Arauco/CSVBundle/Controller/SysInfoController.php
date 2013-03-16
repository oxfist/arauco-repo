<?php

namespace Arauco\CSVBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Arauco\CSVBundle\Entity\SysInfo;

ini_set('memory_limit', '-1');

class SysInfoController extends Controller
{
    /**
     * @Route("/", name="arauco_home")
     * @Template("AraucoBaseBundle:Default:index.html.twig")
     */
    public function SysInfoIndexAction ()
    {
        $LastUpdateDate = NULL;
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT i.LastUpdate FROM AraucoCSVBundle:SysInfo i");

        $LastUpdate = $query->getResult();
        foreach ($LastUpdate as $lastest) {
            $LastUpdateDate = $lastest['LastUpdate']->format('d M, Y G:i:s');
        }

        return array('update' => $LastUpdateDate);

    }
}
