<?php

namespace BlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of ApiController
 *
 * @author Rosana Pencheva <rossana.russeva@gmail.com>
 * @ Route("/api/v1/blog")
 */
class ApiController extends Controller {

    /**
     * 
     * @Route("/check/data.json", name="_app_check_data")
     */
    public function checkDataAction(Request $request) {


        $posts = $this->getDoctrine()
                ->getRepository('BlogBundle:BlogPost')
                ->findBy(['active' => true], ['date' => 'DESC']);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($posts, $request->get('page', 1), 10);

        $data = [];

        if (count($pagination->getItems()) > 0) {
            foreach ($pagination->getItems() as $post) {
                $data[] = [
                    'date' => $post->getDate()->format('M d, Y'),
                    'title' => $post->getTitle(),
                    'id' => $post->getSecureId(),
                    'active' => $post->getActive() ? 'Active' : 'Unactive',
                    'visits' => $post->getVisits(),
                    'url' => $post->getUrl(),
                    'text' => $post->getText()
                ];
            }
        }


        $result = [
            'posts' => $data,
            'page' => $request->get('page', 1),
            'pageCount' => $pagination->getPageCount(),
        ];

        return new JsonResponse($result);
    }

    /**
     * 
     * @Route("/show/data", name="_app_show_data")
     */
    public function showAction(Request $request) {
        $id = $request->get('id');
        
        $blogPost = $this->getDoctrine()
                ->getRepository('BlogBundle:BlogPost')
                ->findOneBySecureId($id);
        if (!$blogPost) {
            throw $this->createNotFoundException('Unable to find entity.');
        }
        $views = $blogPost->getVisits() + 1;
        $blogPost->setVisits($views);


        $em = $this->getDoctrine()->getManager();

        $em->persist($blogPost);
        $em->flush();
        
        return new JsonResponse($blogPost->getVisits());
    }

}
