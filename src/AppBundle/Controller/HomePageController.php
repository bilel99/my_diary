<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class HomePageController extends Controller
{
    /**
     * @Route("/home", name="homepage.index")
     * @Method({"GET"})
     */
    public function indexAction()
    {

        return $this->render('homePage/index.html.twig', array(
            // ...
        ));
    }

}
