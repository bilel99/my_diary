<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Actu;
use AppBundle\Entity\Media;
use AppBundle\Form\ActuType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ActuController extends Controller {


    /**
     * @Route("/actu", name="actu")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER') or has_role('ROLE_ADMIN')")
     */
    public function indexAction(Request $request){
        $actu = new Actu();
        $form = $this->createForm(ActuType::class, $actu);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            if($form['date_fin']->getData() < $form['date_debut']->getData()){
                $this->addFlash('error', 'Date de fin inférieur à date de début !');
            } else {
                $entityActu = $this->getDoctrine()->getManager();
                $actu->setCreatedAt(new \DateTime());
                $entityActu->persist($actu);
                $entityActu->flush();

                $this->addFlash('success', 'Enregistrement effectué avec succès !');
                $this->redirectToRoute('actu');
            }
        }

        // Récupération actu + Relation
        $repositoryActu = $this->getDoctrine()->getRepository(Actu::class);
        $actu = $repositoryActu->getListInActu($this->get('session')->get('users')->getId());

        return $this->render('actu/index.html.twig', array(
            'actu' => $actu,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/actu/{id}", name="actu.show")
     * @Method({"GET"})
     * @Security("has_role('ROLE_USER') or has_role('ROLE_ADMIN')")
     */
    public function showAction(Request $request, Actu $actu){
        return $this->render('actu/show.html.twig', array(
            'actu' => $actu
        ));
    }

    /**
     * @Route("/setStatus/{id}", name="setterStatus")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER') or has_role('ROLE_ADMIN')")
     */
    public function setterInStatusAction(Request $request, $id){
        if($request->isXmlHttpRequest()){
            $entityActu = $this->getDoctrine()->getRepository(Actu::class);
            $actu = $entityActu->find($id);

            // AJAX
            if($actu->getStatus() == 'actif') {
                $actu->setStatus('innactif');
                $this->getDoctrine()->getManager()->flush();
                $message = 'Status est maintenant innactif';
            } else {
                $actu->setStatus('actif');
                $this->getDoctrine()->getManager()->flush();
                $message = 'Status est maintenant actif';
            }
            $response = new JsonResponse();
            return $response->setData(array(
                'message' => $message
            ));
        } else {
            throw new \Exception('Error');
        }
    }

    /**
     * @Route("/actu/edit/{id}", name="actu.edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER') or has_role('ROLE_ADMIN')")
     *
     * @param Actu $actu
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Actu $actu, Request $request){
        $form = $this->createForm(ActuType::class, $actu);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if($form['date_fin']->getData() < $form['date_debut']->getData()){
                $this->addFlash('error', 'Date de fin inférieur à date de début !');
            } else {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', 'Modification effectué avec success !');
                $this->redirectToRoute('actu');
            }
        }

        return $this->render('actu/edit.html.twig', array(
            'actu' => $actu,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/actu/destroy/{id}", name="actu.destroy")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER') or has_role('ROLE_ADMIN')")
     *
     * @param Request $request
     * @param Actu $actu
     * @return $this
     * @throws \Exception
     */
    public function destroyAction(Request $request, Actu $actu){
        // Delete
        $em = $this->getDoctrine()->getManager();
        $em->remove($actu);
        $em->flush();

        // AJAX
        $message = 'Suppression effectué avec succès !';
        $redirectToActu = $this->generateUrl('actu', array('actu' => 'actu'), UrlGeneratorInterface::ABSOLUTE_URL);

        if($request->isXmlHttpRequest()){
            $response = new JsonResponse();
            return $response->setData(array(
                'message' => $message,
                'redirectToActu' => $redirectToActu
            ));
        } else {
            throw new \Exception('Error');
        }
    }

}