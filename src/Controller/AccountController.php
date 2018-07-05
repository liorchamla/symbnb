<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use Cocur\Slugify\Slugify;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/me", name="account")
 */
class AccountController extends Controller
{
    /**
     * @Route("/", name="_index")
     */
    public function myAccount(){
        $user = $this->getUser();
        return $this->render('user/index.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/password-update", name="_password_update")
     */
    public function passwordUpdate(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder){
        $user = $this->getUser();
        $passwordUpdate = new PasswordUpdate();
        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $oldPassword = $user->getPassword();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if(!password_verify($passwordUpdate->getOldPassword(), $user->getPassword())) {
                /**
                 * TODO: Absolument faire en sorte que ce ne soit pas un flash
                 * mais plutôt une erreur dans le formulaire !
                 */
                $this->addFlash(
                    'danger',
                    "L'ancien mot de passe que vous avez tapé ne correspond pas avec celui qui est en place !"
                );
            } else {
                $hash = $encoder->encodePassword($user, $passwordUpdate->getNewPassword());
                $user->setPassword($hash);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "Votre mot de passe a bien été modifié !"
                );

                return $this->redirectToRoute("account_index");
            }
        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/profile", name="_profile")
     */
    public function profile(Request $request, ObjectManager $manager) {
        $user = $this->getUser();
        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash(
                'success',
                "Les modifications de votre profile ont bien été enregistrées ! <a href='{$this->generateUrl('account_index')}'>Retour au profil</a>"
            );
        }

        return $this->render('account/profile.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/register", name="_registration")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder) {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $slugifier = new Slugify();
            $user->setSlug($slugifier->slugify($user->getFirstName() . ' ' . $user->getLastName()));

            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre compte a bien été créé ! Vous pouvez maintenant vous connecter !"
            );

            return $this->redirectToRoute('account_login');
        }

        return $this->render('account/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="_login")
     */
    public function login(){
        return $this->render('account/login.html.twig');
    }

    /**
     * @Route("/check", name="_check")
     */
    public function check() {}

    /**
     * @Route("/logout", name="_logout")
     */
    public function logout() {}
}
