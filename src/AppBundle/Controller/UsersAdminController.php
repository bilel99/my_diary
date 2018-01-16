<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Users;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UsersAdminController extends Controller {


    /**
     * @Route("/admin/users", name="admin.users")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request){
        $em = $this->getDoctrine()->getRepository(Users::class);
        $users = $em->findAll();

        return $this->render('admin/users/index.html.twig', array(
            'users' => $users
        ));
    }

    /**
     * @Route("/admin/users/destroy/{id}", name="admin.users.destroy")
     * @Method({"GET", "POST"})
     */
    public function destroyAction(Users $users, Request $request){
        $em = $this->getDoctrine()->getManager();
        $em->remove($users);
        $em->flush();

        // AJAX
        if($request->isXmlHttpRequest()){
            $message = "Suppression effectué avec succès !";
            $response = new JsonResponse();
            $redirectToRouteUsers = $this->generateUrl('admin.users', array('admin.users' => 'admin.users'), UrlGeneratorInterface::ABSOLUTE_URL);
            return $response->setData(array(
                "message" => $message,
                "redirectToRouteUsers" => $redirectToRouteUsers
            ));
        } else {
            throw new \Exception('Error');
        }
    }

}