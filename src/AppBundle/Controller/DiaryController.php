<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Categorie;
use AppBundle\Entity\Diary;
use AppBundle\Entity\Media;
use AppBundle\Form\CategorieType;
use AppBundle\Form\DiaryAllElementType;
use AppBundle\Form\DiaryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DiaryController extends Controller {


    /**
     * @Route("/diary", name="diary")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER') or has_role('ROLE_ADMIN')")
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
            if($form['date_fin']->getData() < $form['date_debut']->getData()){
                $this->addFlash('error', 'Date de fin inférieur à date de début !');
            } else {
                // Return Entity Categorie
                $entityCategorie = $this->getDoctrine()->getRepository(Categorie::class);
                $objectCategorie = $entityCategorie->find($_POST['categorie']);

                $entityDiary = $this->getDoctrine()->getManager();

                $diary->setCategorie($objectCategorie);
                $diary->setCreatedAt(new \DateTime());

                $entityDiary->persist($diary);
                $entityDiary->flush();

                foreach($form['media']->getData() as $media){
                    $diary->addMedia($media);
                }

                $this->addFlash('success', 'Enregistrement effectué avec succès !');
                return $this->redirectToRoute('diary');
            }
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

        // Requête recupération des posts avec leur relation (Foreign Key)
        $entityDiary = $this->getDoctrine()->getRepository(Diary::class);
        $diary = $entityDiary->getListInDiary($this->get('session')->get('users')->getId());

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
     * @Security("has_role('ROLE_USER') or has_role('ROLE_ADMIN')")
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
     * @Security("has_role('ROLE_USER') or has_role('ROLE_ADMIN')")
     *
     * @param Diary $diary
     * @param Request $request
     * @return render
     */
    public function updateAction(Diary $diary, Request $request){
        $form = $this->createForm(DiaryAllElementType::class, $diary);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if($form['date_fin']->getData() < $form['date_debut']->getData()){
                $this->addFlash('error', 'Date de fin inférieur à date de début !');
            } else {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', 'Modification effectué avec success !');
                $this->redirectToRoute('diary');
            }
        }

        return $this->render('diary/edit.html.twig', array(
            'diary' => $diary,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/diary/{id}", name="diary.show")
     * @Method({"GET"})
     * @Security("has_role('ROLE_USER') or has_role('ROLE_ADMIN')")
     *
     * @param Diary $diary
     * @return render
     */
    public function showAction(Diary $diary){
        return $this->render('diary/show.html.twig', array(
            'diary' => $diary
        ));
    }

    /**
     * @Route("/diary/destroy/{id}", name="diary.destroy")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER') or has_role('ROLE_ADMIN')")
     *
     * @param Request $request
     * @param Diary $diary
     * @return $this
     * @throws \Exception
     */
    public function destroyAction(Diary $diary, Request $request){
        $em = $this->getDoctrine()->getManager();
        $em->remove($diary);
        $em->flush();

        // AJAX
        $message = "Suppression effectué avec succès !";
        $redirectToDiary = $this->generateUrl('diary', array('diary' => 'diary'), UrlGeneratorInterface::ABSOLUTE_URL);

        if($request->isXmlHttpRequest()){
            $response = new JsonResponse();
            return $response->setData(array(
                'message' => $message,
                'redirectToDiary'  => $redirectToDiary
            ));
        } else {
            throw new \Exception('Error');
        }
    }

}