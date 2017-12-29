<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Pays;
use AppBundle\Entity\Users;
use AppBundle\Entity\Ville;
use AppBundle\Form\ChangePasswordType;
use AppBundle\Form\ProfilType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AccountController extends Controller {


    /**
     * AccountController constructor.
     * @param UrlGeneratorInterface $router
     */
    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @Route("/profil/{id}", name="profil")
     * @Method({"GET", "POST"})
     */
    public function profilAction(Request $request, Users $users){
        // Récupération de la tables ville
        $repositoryUsers = $this->getDoctrine()->getRepository(Users::class);
        $users = $repositoryUsers->findAllWithAssociateTable();
        $users = $users[0];

        $libellePays = '';
        if($users->getVille() != null){
            // Récupération de la table pays
            $repositoryPays = $this->getDoctrine()->getRepository(Pays::class);
            $pays = $repositoryPays->findOneBy(array('id' => $users->getVille()->getPays()->getId()));
            $libellePays = $pays->getNomFrFr();
        }

        // Form
        $form = $this->createForm(ProfilType::class, $users);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $libelleVille = $_POST['ville'];
            $repositoryVille = $this->getDoctrine()->getRepository(Ville::class);
            $ville = $repositoryVille->getVille($libelleVille);
            $ville = $ville[0];

            // Mise à jour en BDD
            $users->setVille($ville);
            $this->getDoctrine()->getManager()->flush();
            // Mise à jour de la session
            $this->get('session')->set('users', $users);
            $this->addFlash('success', 'Votre profil à bien été édité !');
            return $this->redirectToRoute('homepage.index');
        }
        return $this->render('account/profil.html.twig', [
            'users' => $users,
            'libellePays' => $libellePays,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/villes/{cp}", name="villes")
     * @Method({"GET", "POST"})
     */
    public function villesAction(Request $request, $cp){
        if($request->isXmlHttpRequest()){
            $em = $this->getDoctrine()->getRepository(Ville::class);
            $villeCodePostal = $em->findOneBy(array('zipcode' => $cp));

            if($villeCodePostal) {
                $ville = $villeCodePostal->getLibelle();
            } else {
                $ville = null;
            }
            // AJAX
            $response = new JsonResponse();
            return $response->setData(array(
                'ville' => $ville
            ));
        } else {
            throw new \Exception('Error');
        }
    }

    /**
     * @Route("/changePassword/{id}", name="changePassword")
     * @Method({"GET", "POST"})
     */
    public function changePasswordAction(Request $request, Users $users) {
        $form = $this->createForm(ChangePasswordType::class, $users);
        $form->handleRequest($request);

        $usersRepository = $this->getDoctrine()->getRepository(Users::class);
        if($form->isSubmitted() && $form->isValid()){
            $pass = $usersRepository->isMyPassword($users->getId());
            if($pass[0]['password'] === sha1($form['oldPassword']->getData().' '.$this->getParameter('salt'))){
                $em = $this->getDoctrine()->getManager();
                $users->setPassword(sha1($form['password']->getData().' '.$this->getParameter('salt')));
                $em->persist($users);
                $em->flush();

                $this->addFlash('success', 'Votre mot de passe à bien été modifier !');
                return $this->redirectToRoute('profil', array(
                    'id' => $users->getId()
                ));
            }else{
                $this->addFlash('error', 'Votre ancien mot de passe est incorrect !');
            }
        }
        return $this->render("account/changePassword.html.twig", array(
            'users' => $users,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/deleteUser/{id}", name="deleteUser")
     * @Method({"GET", "POST"})
     */
    public function deleteUserAction(Request $request, Users $users) {
        // Delete
        $em = $this->getDoctrine()->getManager();
        $em->remove($users);
        $em->flush();

        // AJAX
        $message = "Votre compte à bien été supprimé !";
        $redirectToRouteLogin = $this->generateUrl('login', array('login' => 'login'), UrlGeneratorInterface::ABSOLUTE_URL);

        if($request->isXmlHttpRequest()) {
            // force manual logout of logged in user
            $this->get('security.token_storage')->setToken(null);
            // Suppression des session
            $this->get('session')->remove('users');
            $this->get('session')->clear();

            $response = new JsonResponse();
            return $response->setData(array(
                'message' => $message,
                'redirectToRouteLogin' => $redirectToRouteLogin
            ));
        } else {
            throw new \Exception('Error');
        }
    }

}