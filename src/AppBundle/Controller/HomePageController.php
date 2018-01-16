<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Actu;
use AppBundle\Entity\Diary;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class HomePageController extends Controller
{
    /**
     * @Route("home", name="homepage.index")
     * @Method({"GET"})
     * @Security("has_role('ROLE_USER') or has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        // récupération des actu
        $entityActu = $this->getDoctrine()->getRepository(Actu::class);
        $actu = $entityActu->getActuHome(3);

        $entityDiary = $this->getDoctrine()->getRepository(Diary::class);
        $posts = $entityDiary->getDiaryHome(3);

        return $this->render('homePage/index.html.twig', array(
            'actu' => $actu,
            'posts' => $posts
        ));
    }

}
