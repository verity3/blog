<?php

namespace NewsBundle\Controller;

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
 * @Route("/api/v1/news")
 */
class ApiController extends Controller {

    /**
     * 
     * @Route("/check/data.json", name="_app_check_data")
     */
    public function checkDataAction(Request $request) {


        $posts = $this->getDoctrine()
                ->getRepository('NewsBundle:NewsPost')
                ->findBy(['active' => true], ['date' => 'DESC']);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($posts, $request->get('page', 1), 10);

        $data = [];

        if (count($pagination->getItems()) > 0) {
            foreach ($pagination->getItems() as $post) {
                $files = [];
            if(count($post->getFiles()) > 0){
                foreach($post->getFiles() as $file){
                $files[] = $file->getFile();
                }                
            }
                $data[] = [
                    'date' => $post->getDate()->format('M d, Y'),
                    'title' => $post->getTitle(),
                    'id' => $post->getSecureId(),
                    'active' => $post->getActive() ? 'Active' : 'Unactive',
                    'text' => $post->getText(),
                    'files' => $files,
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
        
        $newsPost = $this->getDoctrine()
                ->getRepository('NewsBundle:NewsPost')
                ->findOneBySecureId($id);
        if (!$newsPost) {
            throw $this->createNotFoundException('Unable to find entity.');
        }
        
        
        return new JsonResponse(1);
    }

}
