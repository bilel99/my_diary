<?php
/**
 * Created by PhpStorm.
 * User: bilel
 * Date: 10/01/2018
 * Time: 12:15
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{

    /**
     * @Route("/admin/dashboard", name="admin.dashboard")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param Request $request
     * @return render
     */
    public function indexAction(Request $request){
        // Dashboard
        return $this->render("admin/dashboard/index.html.twig", array(

        ));
    }

}