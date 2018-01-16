<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Categorie;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CategorieAdminController extends Controller {


    /**
     * @Route("/admin/categorie", name="admin.categorie")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request){
        $em = $this->getDoctrine()->getRepository(Categorie::class);
        $categorie = $em->findAll();

        return $this->render('admin/categorie/index.html.twig', array(
            'categorie' => $categorie
        ));
    }

    /**
     * @Route("/admin/categorie/destroy/{id}", name="admin.categorie.destroy")
     * @Method({"GET", "POST"})
     */
    public function destroyAction(Categorie $categorie, Request $request){
        $em = $this->getDoctrine()->getManager();
        $em->remove($categorie);
        $em->flush();

        // AJAX
        if($request->isXmlHttpRequest()){
            $message = "Suppression effectué avec succès !";
            $response = new JsonResponse();
            $redirectToRouteCategorie = $this->generateUrl('admin.categorie', array('admin.categorie' => 'admin.categorie'), UrlGeneratorInterface::ABSOLUTE_URL);
            return $response->setData(array(
                "message" => $message,
                "redirectToRouteCategorie" => $redirectToRouteCategorie
            ));
        } else {
            throw new \Exception('Error');
        }
    }

}