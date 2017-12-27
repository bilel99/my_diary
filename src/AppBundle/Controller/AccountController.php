<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Users;
use AppBundle\Form\ChangePasswordType;
use AppBundle\Form\ProfilType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AccountController extends Controller {


    /**
     * @Route("/profil/{id}", name="profil")
     * @Method({"GET", "POST"})
     */
    public function profilAction(Request $request, Users $users){
        // Form
        $form = $this->createForm(ProfilType::class, $users);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // Mise à jour en BDD
            $this->getDoctrine()->getManager()->flush();
            // Mise à jour de la session
            $this->get('session')->set('users', $users);
            $this->addFlash('success', 'Votre profil à bien été édité !');
            return $this->redirectToRoute('homepage.index');
        }
        return $this->render('account/profil.html.twig', [
            'users' => $users,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/changePassword/{id}", name="changePassword")
     * @Method({"GET", "POST"})
     */
    public function changePasswordAction(Request $request, Users $users) {



        return $this->render("account/changePassword.html.twig", array(
            'users' => $users
        ));
    }

    /**
     * @Route("/deleteUser/{id}", name="deleteUser")
     * @Method({"GET", "POST"})
     */
    public function deleteUserAction(Request $request, Users $users) {


    }

}