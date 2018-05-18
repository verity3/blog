<?php

namespace AuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AuthBundle\Form\LoginType;


/**
 * Description of SecurityController
 *
 * @author Rosana Pencheva <rossana.russeva@gmail.com>
 * @Template()
 */
class SecurityController extends Controller {

    /**
     * @Route("/login", name="security_login")
     * @Template
     */
    public function loginAction() {
        $authenticationUtils = $this->get('security.authentication_utils');
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $form = $this->createForm(LoginType::class, [
            '_username' => $lastUsername,
        ]);
    
        return  array(
                'form' => $form->createView(),
                'error' => $error,
            );
        
     
    }
    
    /**
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction()
    {
        throw new \Exception('this should not be reached!');
    }

}
