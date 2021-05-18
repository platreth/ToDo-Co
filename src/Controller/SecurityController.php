<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;



class SecurityController extends AbstractController
{
    /**
    * @Route("/login", name="login")
    */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
    /**
     * @codeCoverageIgnore
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        // This code is never executed.
    }

    /**
    * @codeCoverageIgnore
    * @Route("/logout", name="logout")
    */
    public function logoutCheck()
    {
        // This code is never executed.
    }
}
