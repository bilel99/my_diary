<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Actu;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class HomePageController extends Controller
{
    /**
     * @Route("home", name="homepage.index")
     * @Method({"GET"})
     */
    public function indexAction()
    {
        // récupération des actu
        $entityActu = $this->getDoctrine()->getRepository(Actu::class);
        $actu = $entityActu->getActuHome(3);

        return $this->render('homePage/index.html.twig', array(
            'actu' => $actu
        ));
    }

}
