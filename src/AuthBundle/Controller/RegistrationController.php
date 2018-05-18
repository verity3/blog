<?php

namespace AuthBundle\Controller;

use AuthBundle\Form\UserType;
use AuthBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AuthBundle\Form\ChangePassType;
use AuthBundle\Form\AskCodeType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Description of RegistrationController
 *
 * @author Rosana Pencheva <rossana.russeva@gmail.com>
 */
class RegistrationController extends Controller {

    /**
     * @Route("/register", name="user_registration")
     * @Template()
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder) {

        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $code = $this->random_str(60);
            $password = $this->random_str(10);
            $username = $user->getEmail();
            $passwordTemp = $passwordEncoder->encodePassword($user, $password); //dump($passwordTemp);exit;
            $user->setRoles(array('ROLE_USER'));
            $user->setCode($code);
            $user->setUsername($username);
            $user->setPasswordTemp($passwordTemp);
            $user->setActive(false);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();


            if ($user) {
                try {
                    // Send mail
                    $message = \Swift_Message::newInstance()
                            ->setSubject('Welcome to News.com')
                            ->setFrom($this->container->getParameter("mail_noreplay"))
                            ->setTo($user->getEmail())
                            ->setContentType("text/html");
                  //  $url = $this->generateUrl('_system_auth_activate', array('code' => $code));
                    $url = $this->container->get('router')->generate('_system_auth_activate', 
                            array('code' => $code), UrlGeneratorInterface::ABSOLUTE_URL);

                    $message->setBody($this->renderView('AuthBundle:Mail:registerSuccess.txt.twig', array(
                                'user' => $user,
                                'url' => $url
                    )));
                    $this->get('mailer')->send($message);
                } catch (\Exception $e) {
                    
                }
            }
            $this->get('session')->getFlashBag()->add('success', "Your account has been created! We have sent you an email to activate your account.");
            return $this->redirectToRoute('frontend_homepage');
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/user/activate/{code}", name="_system_auth_activate")
     * 
     */
    public function activateAction($code) {

        $user = $this->getDoctrine()
                ->getRepository('AuthBundle:User')
                ->findOneBy(['code' => $code]);
        $entityManager = $this->getDoctrine()->getManager();

        if ($user) {
            $user->setActive(true);
            $user->setCode('');
            $entityManager->persist($user);
            $entityManager->flush();
            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->container->get('security.token_storage')->setToken($token);
            $this->container->get('session')->set('_security_main', serialize($token));
            $this->addFlash('success', 'Please, create your password!');
            $url = $this->generateUrl('_system_auth_change_pass');
            return $this->redirect($url);
        } else {
            $this->addFlash('success', 'The activation code has already expired. You can ask for new.');
            $url = $this->generateUrl('_system_auth_forgot_pass');
            return $this->redirect($url);
        }
    }

    /**
     * @Route("/user/change/password", name="_system_auth_change_pass")
     * @Template()
     * @Security("has_role('ROLE_USER')")
     */
    public function changePassAction(Request $request) {
        $user = $this->getUser();
        $form = $this->createForm(ChangePassType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPasswordTemp("");
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Your password was saved!');
            $url = $this->generateUrl('news_homepage');
            return $this->redirect($url);
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/user/forgot/password", name="_system_auth_forgot_pass")
     * @Template()
     */
    public function forgotPassAction(Request $request, UserPasswordEncoderInterface $passwordEncoder) {

        $form = $this->createForm(AskCodeType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getDoctrine()
                    ->getRepository('AuthBundle:User')
                    ->findOneBy(['email' => $form['email']->getData()]);
            if ($user) {
                $code = $this->random_str(60);
                $password = $this->random_str(10);
                $username = $user->getEmail();
                $passwordTemp = $passwordEncoder->encodePassword($user, $password);
                $user->setCode($code);
                $user->setPasswordTemp($passwordTemp);
                $user->setActive(false);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                try {
                    // Send mail
                    $message = \Swift_Message::newInstance()
                            ->setSubject('Welcome to News.com')
                            ->setFrom($this->container->getParameter("mail_noreplay"))
                            ->setTo($user->getEmail())
                            ->setContentType("text/html");
                   $url = $this->container->get('router')->generate('_system_auth_activate', 
                            array('code' => $code), UrlGeneratorInterface::ABSOLUTE_URL);

                    $message->setBody($this->renderView('AuthBundle:Mail:registerSuccess.txt.twig', array(
                                'user' => $user,
                                'url' => $url
                    )));
                    $this->get('mailer')->send($message);
                } catch (\Exception $e) {
                    
                }
            }
            $this->get('session')->getFlashBag()->add('success', "We have sent you an email with new activation code.");
            return $this->redirectToRoute('frontend_homepage');
        }

        return array('form' => $form->createView());
    }

    /**
     * 
     * @param int $length      How many characters do we want?
     * @param string $keyspace A string of all possible characters
     *                         to select from
     * @return string
     */
    public function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }

}
