<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Diary;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DiaryAdminController extends Controller {


    /**
     * @Route("/admin/diary", name="admin.diary")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request){
        $em = $this->getDoctrine()->getRepository(Diary::class);
        $diary = $em->findAll();

        return $this->render('admin/diary/index.html.twig', array(
            'diary' => $diary
        ));
    }

    /**
     * @Route("/admin/diary/destroy/{id}", name="admin.diary.destroy")
     * @Method({"GET", "POST"})
     */
    public function destroyAction(Diary $diary, Request $request){
        $em = $this->getDoctrine()->getManager();
        $em->remove($diary);
        $em->flush();

        // AJAX
        if($request->isXmlHttpRequest()){
            $message = "Suppression effectué avec succès !";
            $response = new JsonResponse();
            $redirectToRouteDiary = $this->generateUrl('admin.diary', array('admin.diary' => 'admin.diary'), UrlGeneratorInterface::ABSOLUTE_URL);
            return $response->setData(array(
                "message" => $message,
                "redirectToRouteDiary" => $redirectToRouteDiary
            ));
        } else {
            throw new \Exception('Error');
        }
    }

}