<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Categorie;
use AppBundle\Entity\Diary;
use AppBundle\Form\CategorieType;
use AppBundle\Form\DiaryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DiaryController extends Controller {


    /**
     * @Route("/diary", name="diary")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER', 'ROLE_ADMIN')")
     */
    public function indexAction(Request $request){
        $diary = new Diary();
        $form = $this->createForm(DiaryType::class, $diary, array(
            'action' => $this->generateUrl('diary'),
            'method' => 'POST',
            'attr' => array(
                'id' => 'form_create_diary'
            )
        ));
        $form->handleRequest($request);

        $categorie = new Categorie();
        $formCategorie = $this->createForm(CategorieType::class, $categorie, array(
            'action' => $this->generateUrl('diary'),
            'method' => 'POST',
            'attr' => array(
                'id' => 'form_create_categorie'
            )
        ));
        $formCategorie->handleRequest($request);

        // Add Diary In PHP Request
        if($form->isSubmitted() && $form->isValid()){

        }

        // Add Categorie in AJAX Request
        if($formCategorie->isSubmitted() && $formCategorie->isValid()){
            $categorie = new Categorie();
            $em = $this->getDoctrine()->getManager();
            $categorie->setLangue($formCategorie['langue']->getData());
            $categorie->setNom($formCategorie['nom']->getData());
            $categorie->setCreatedAt(new \DateTime());
            $em->persist($categorie);
            $em->flush();

            // AJAX
            $message = 'Création effectué avec succès !';
            if($request->isXmlHttpRequest()){
                $response = new JsonResponse();
                return $response->setData(array(
                    'message' => $message
                ));
            } else {
                throw new \Exception('Error');
            }
        }

        return $this->render('diary/index.html.twig', array(
            'diary' => $diary,
            'form' => $form->createView(),
            'categorie' => $categorie,
            'formCategorie' => $formCategorie->createView()
        ));
    }

    /**
     * @Route("/ajaxListCategorie", name="ajaxListCategorie")
     * @Method({"GET"})
     * @Security("has_role('ROLE_USER', 'ROLE_ADMIN')")
     */
    public function ajaxListCategorieAction(Request $request){
        if($request->isXmlHttpRequest()){
            $entityCategorie = $this->getDoctrine()->getRepository(Categorie::class);
            $categorie = $entityCategorie->findAll();

            if($categorie){
                $cat[] = array();
                foreach($categorie as $row){
                    $cat[$row->getId()] = $row->getNom();
                }
            } else {
                $categorie = null;
            }
            // AJAX
            $response = new JsonResponse();
            return $response->setData(array(
                'categorie' => $cat
            ));
        } else {
            throw new \Exception('Error');
        }
    }

    /**
     * @Route("/diary/edit/{id}", name="diary.edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER', 'ROLE_ADMIN')")
     *
     * @param Diary $diary
     * @param Request $request
     */
    public function editAction(Diary $diary, Request $request){

    }

    /**
     * @Route("/diary/{id}", name="diary.show")
     * @Method({"GET"})
     * @Security("has_role('ROLE_USER', 'ROLE_ADMIN')")
     *
     * @param Diary $diary
     */
    public function showAction(Diary $diary){

    }

    /**
     * @Route("/diary/destroy/{id}", name="diary.destroy")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER', 'ROLE_ADMIN')")
     *
     * @param Diary $diary
     * @param Request $request
     */
    public function destroyAction(Diary $diary, Request $request){

    }
}