<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use BlogBundle\Form\BlogType;
use BlogBundle\Entity\BlogPost;

/**
 * Description of FrontendController
 *
 * @author Rosana Pencheva <rossana.russeva@gmail.com>
 */
class FrontendController extends Controller{
   
    /**
     * @Route("/", name="frontend_homepage")
     * @Template()
     */
    public function indexAction(Request $request) {
         $posts = $this->getDoctrine()
                ->getRepository('BlogBundle:BlogPost')
                ->findBy(['active' => true], ['date' => 'DESC']);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($posts, $request->get('page', 1), 2);
        return[
            'pagination' => $pagination,
        ];
    }
    
    /**
     * @Route("/show/{url}", name="frontend_show_post")
     * @Template()
     */
    public function showAction($url) {//dump($url);exit;
         $post = $this->getDoctrine()
                ->getRepository('BlogBundle:BlogPost')
                ->findOneBy(['url' => "{$url}"]);
          if (!$post) {
            throw $this->createNotFoundException('Unable to find entity.');
        }
         $em = $this->getDoctrine()->getManager();
         $post->setVisits($post->getVisits() + 1);
         $em->persist($post);
         $em->flush();
        return[
            'post' => $post
        ];
    }
    
    /**
     * @Route("/frontend/list", name="frontend_list")
     * @Template()
     */
    public function listAction() {
        return[];
    }
}
