<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use BlogBundle\Form\TagType;
use BlogBundle\Entity\Tags;

/**
 * 
 *
 * @author  Rosana Pencheva <rossana.russeva@gmail.com>
 * 
 * @Security("has_role('ROLE_ADMIN')")
 * 
 */
class TagController extends Controller {

    /**
     * @Route("/tags", name="tags_list")
     * @Template()
     */
    public function indexAction(Request $request) {
        
         $query = $this->getDoctrine()
                ->getRepository('BlogBundle:Tags')
                ->createQueryBuilder('t')  
                ->getQuery()
                 ;
         $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, $request->get('page', 1), 5
        );
        return [
            'pagination' => $pagination
        ];
    }

    /**
     * @Route("/create/tag", name="tag_create")
     * @Template()
     */
    public function createAction(Request $request) {
        $tags = new Tags();

        //  $author = $this->getUser();
        // $blogPost->setAuthor($author);

        $form = $this->createForm(TagType::class, $tags);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        // Check is valid
        if ($form->isSubmitted() && $form->isValid()) {
           
            $em->persist($tags);
            $em->flush($tags);

            $this->addFlash('success', 'Congratulations! Your post is created');

            $url = $this->generateUrl('tag_edit', [ 'id' => $tags->getSecureId()]);

            return $this->redirect($url);
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/edit/{id}/tag", name="tag_edit")
     * @Template()
     */
    public function editAction(Request $request, $id) {
        $tags = $this->getDoctrine()
                ->getRepository('BlogBundle:Tags')
                ->findOneBySecureId($id);
        if (!$tags) {
            throw $this->createNotFoundException('Unable to find entity.');
        }
        //  $author = $this->getUser();
        // $blogPost->setAuthor($author);

        $form = $this->createForm(TagType::class, $tags);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        // Check is valid
        if ($form->isSubmitted() && $form->isValid()) {
            
            $em->persist($tags);
            $em->flush($tags);

            $this->addFlash('success', 'Congratulations! Your post is edited.');

            // return $this->redirectToRoute('blog_homepage');

            $url = $this->generateUrl('tag_edit', [ 'id' => $tags->getSecureId()]);

            return $this->redirect($url);
        }

        return [
            'form' => $form->createView()
        ];
    }

}
