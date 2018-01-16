<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Actu;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ActuAdminController extends Controller {


    /**
     * @Route("/admin/actu", name="admin.actu")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request){
        $em = $this->getDoctrine()->getRepository(Actu::class);
        $actu = $em->findAll();

        return $this->render('admin/actu/index.html.twig', array(
            'actu' => $actu
        ));
    }

    /**
     * @Route("/admin/actu/destroy/{id}", name="admin.actu.destroy")
     * @Method({"GET", "POST"})
     */
    public function destroyAction(Actu $actu, Request $request){
        $em = $this->getDoctrine()->getManager();
        $em->remove($actu);
        $em->flush();

        // AJAX
        if($request->isXmlHttpRequest()){
            $message = "Suppression effectué avec succès !";
            $response = new JsonResponse();
            $redirectToRouteActu = $this->generateUrl('admin.actu', array('admin.actu' => 'admin.actu'), UrlGeneratorInterface::ABSOLUTE_URL);
            return $response->setData(array(
                "message" => $message,
                "redirectToRouteActu" => $redirectToRouteActu
            ));
        } else {
            throw new \Exception('Error');
        }
    }

}