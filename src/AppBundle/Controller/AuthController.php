<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Media;
use AppBundle\Entity\Role;
use AppBundle\Entity\Users;
use AppBundle\Form\ChangePasswordType;
use AppBundle\Form\ForgotStepFinalType;
use AppBundle\Form\ForgotType;
use AppBundle\Form\LoginType;
use AppBundle\Form\ProfilType;
use AppBundle\Form\RegisterType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

class AuthController extends Controller
{

    /**
     * @Route("/", name="login")
     * @Method({"GET", "POST"})
     */
    public function loginAction(Request $request) {

        if($this->get('session')->get('users')){
            return $this->redirectToRoute('homepage.index');
        }

        $users = new Users();
        $form = $this->createForm(LoginType::class, $users);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $email = $form['email']->getData();
            $password = $form['password']->getData();

            $repository = $this->getDoctrine()->getRepository(Users::class);
            $result = $repository->authorizedAccess($email, sha1($password.' '.$this->getParameter('salt')));
            if(count($result) === 1) {
                // Changement role via Symfony, générer un nouveau token
                $token = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken(
                    $result[0],
                    null,
                    'main',
                    array($result[0]->getRole()->getRole())
                );
                $this->container->get('security.token_storage')->setToken($token);
                // Fin changement role via symfony

                $this->get('session')->set('users', $result[0]);
                $users = $this->get('session')->get('users');
                $this->addFlash("info", "bienvenue ".$users->getEmail());
                return $this->redirectToRoute('homepage.index');
            } else {
                $this->addFlash('error', 'Email ou mot de passe incorrect!');
                $this->redirectToRoute('login');
            }
        }
        return $this->render('Auth/login.html.twig', [
            'users' => $users,
            'form'  => $form->createView()
        ]);
    }

    /**
     * @Route("/register", name="register")
     * @Method({"GET", "POST"})
     * @return string
     */
    public function registerAction(Request $request, \Swift_Mailer $mailer) {

        if($this->get('session')->get('users')){
            return $this->redirectToRoute('homepage.index');
        }

        // Création formulaire
        $users = new Users();
        $form = $this->createForm(RegisterType::class, $users);

        $form->handleRequest($request);

        $instanceRole = $this->getDoctrine()->getRepository(Role::class);
        $role = $instanceRole->find(1);

        $instanceMedia = $this->getDoctrine()->getRepository(Media::class);
        $media = $instanceMedia->find(1);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $users->setCreatedAt(new \DateTime());
            $users->setRole($role);
            // Cryptage du password + grain de sel
            $users->setPassword(sha1($form['password']->getData().' '.$this->getParameter('salt')));

            $em->persist($users);
            $em->flush();

            /**
             * Connection suite à l'inscription
             */
            $entityUsers = $this->getDoctrine()->getRepository(Users::class);
            $result = $entityUsers->find($users->getId());
            $this->get('session')->set('users', $result);

            // Envoie email
            $name = 'bilel.bekkouche@gmail.com';
            $email = $form['email']->getData();
            $message = (new \Swift_Message('Register'))
                ->setFrom('bilel.bekkouche@gmail.com')
                ->setTo('bilel.bekkouche@hotmail.fr')
                ->setBody(
                    $this->renderView(
                        'email/register.html.twig',
                        array(
                            'name' => $name,
                            'email' => $email
                        )
                    ),
                    'text/html'
                );
            $mailer->send($message);

            $this->addFlash('success', 'Compte créer avec succès!');
            return $this->redirectToRoute('homepage.index');
        }

        return $this->render('Auth/register.html.twig', [
            'users' => $users,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/forgot", name="forgot")
     * @Method({"GET", "POST"})
     */
    public function forgotPassAction(Request $request, \Swift_Mailer $mailer){

        if($this->get('session')->get('users')){
            return $this->redirectToRoute('homepage.index');
        }

        $users = new Users();
        $form = $this->createForm(ForgotType::class, $users);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // Générer password
            $newPass = $this->rand_passwd();
            $email = $form['email']->getData();

            // Vérification si email existe
            $users = $this->getDoctrine()->getRepository(Users::class);
            $validEmail = $users->findBy(array("email" => $form['email']->getData()));

            if(count($validEmail) === 1) {
                // Sauvegarde new pass champ forgot table
                $em = $this->getDoctrine()->getManager();
                $upd = $em->getRepository(Users::class)->find($validEmail[0]->getId());

                if(!$upd){
                    throw $this->createNotFoundException(
                        'No users found for email '.$form['email']->getData()
                    );
                }

                $upd->setForgot($newPass);
                $em->flush();

                // Envoie email
                $message = (new \Swift_Message('Mot de passe oublié'))
                    ->setFrom('bilel.bekkouche@gmail.com')
                    ->setTo('bilel.bekkouche@hotmail.fr')
                    ->setBody(
                        $this->renderView(
                            'email/forgot.html.twig',
                            array(
                                'randomPassword' => $newPass,
                                'email' => $email
                            )
                        ),
                        'text/html'
                    );
                $mailer->send($message);
            } else {
                $this->addFlash("error", "unknown email");
                $this->redirectToRoute("forgot");
            }
        }
        return $this->render("Auth/forgot.html.twig", [
            "users" => $users,
            "form"  => $form->createView()
        ]);
    }

    /**
     * @Route("/forgotStepFinal", name="forgotStepFinal")
     * @Method({"GET", "POST"})
     */
    public function forgotStepFinalAction(Request $request){

        if($this->get('session')->get('users')){
            return $this->redirectToRoute('homepage.index');
        }

        $users = new Users();
        $form = $this->createForm(ForgotStepFinalType::class, $users);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // Récupération objet users
            $formPassword = $form['password']->getData();
            $result = $this->getDoctrine()->getRepository(Users::class);
            $u = $result->findBy(array("forgot" => $form['password']->getData()));

            if(count($u) === 1) {
                $em = $this->getDoctrine()->getManager();
                $upd = $em->getRepository(Users::class)->find($u[0]->getId());

                if(!$upd){
                    throw $this->createNotFoundException(
                        'No users found for pass '.$form['password']->getData()
                    );
                }

                //$upd->setPassword($form['password']->getData());
                //$em->flush();

                $this->addFlash("success", "Mot de passe valide");
                return $this->redirectToRoute('changePassword', array(
                    'user' => $formPassword
                ));
            } else {
                $this->addFlash('error', 'Mot de passe entrer inconnue !');
            }
        }

        return $this->render("Auth/forgotStepFinal.html.twig", [
            'users' => $users,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/changePassword/{user}", name="changePassword")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @param $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function changePasswordAction(Request $request, $user){

        if($this->get('session')->get('users')){
            return $this->redirectToRoute('homepage.index');
        }

        // Récupération objet users
        $result = $this->getDoctrine()->getRepository(Users::class);
        $user = $result->findBy(array("forgot" => $request->attributes->get('user')));

        $form = $this->createForm(ChangePasswordType::class, $user[0]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            foreach ($user as $u) {
                $em = $this->getDoctrine()->getManager();
                $u->setPassword(sha1($form['password']->getData().' '.$this->getParameter('salt')));
                $em->persist($u);
                $em->flush();
            }
            $this->addFlash("success", "Modification de votre mot de passe efféctué avec succès !");
            return $this->redirectToRoute("login");
        }

        return $this->render('Auth/changePass.html.twig', array(
            'user'    => $user,
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/logout", name="logout")
     * @Method({"GET"})
     * @return string
     */
    public function logoutAction() {
        // Session remove users unset($_SESSION['users']); => $this->get('session')->remove('users');
        // $session_destroy() => $this->get('session')->clear();

        // Remove Token role via symfony
        $this->container->get('security.token_storage')->setToken(null);

        $this->get('session')->remove('users');
        $this->addFlash('info', 'déconnection terminé!');
        return $this->redirectToRoute('login');
    }

    /**
     * Generate password random shuffle
     * @param int $length
     * @param string $chars
     * @return string
     */
    public function rand_passwd($length = 8, $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') {
        return substr(str_shuffle($chars), 0, $length);
    }
}
