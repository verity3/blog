<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use BlogBundle\Form\BlogType;
use BlogBundle\Entity\BlogPost;
use BlogBundle\Entity\BlogPostTags;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * 
 *
 * @author  Rosana Pencheva <rossana.russeva@gmail.com>
 * 
 * @Security("has_role('ROLE_ADMIN')")
 * 
 */
class BlogController extends Controller {

    /**
     * @Route("/blog", name="blog_homepage")
     * @Template()
     */
    public function indexAction(Request $request) {

        $query = $this->getDoctrine()
                ->getRepository('BlogBundle:BlogPost')
                ->createQueryBuilder('t')
                ->orderBy('t.date', 'DESC')
                ->getQuery()
        ;
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, $request->get('page', 1), 25
        );
        return [
            'pagination' => $pagination
        ];
    }

    /**
     * @Route("/create/blog", name="blog_create")
     * @Template()
     */
    public function createAction(Request $request) {
        $blogPost = new BlogPost();


        $form = $this->createForm(BlogType::class, $blogPost);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        // Check is valid
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->request->get('blog');
            if (isset($data['tags'])) {
                foreach ($data['tags'] as $tadId) {
                    $tag = $this->getDoctrine()
                            ->getRepository('BlogBundle:Tags')
                            ->findOneById($tadId);
                    if ($tag) {
                        $postTag = new BlogPostTags();
                        $postTag->setTag($tag);
                        $postTag->setBlogPost($blogPost);
                        $em->persist($postTag);
                        $blogPost->addTag($postTag);
                    }
                }
            }

            $blogPost->setVisits(0);
            $blogPost->setUrl(strtolower($blogPost->getUrl()));
            $em->persist($blogPost);
            $em->flush($blogPost);

            $this->addFlash('success', 'Congratulations! Your post is created');

            // return $this->redirectToRoute('blog_homepage');

            $url = $this->generateUrl('blog_edit', [ 'id' => $blogPost->getSecureId()]);

            return $this->redirect($url);
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/edit/{id}/blog", name="blog_edit")
     * @Template()
     */
    public function editAction(Request $request, $id) {
        $blogPost = $this->getDoctrine()
                ->getRepository('BlogBundle:BlogPost')
                ->findOneBySecureId($id);
        if (!$blogPost) {
            throw $this->createNotFoundException('Unable to find entity.');
        }
        $dataTags = [];
        $originalTags = new ArrayCollection();

        if ($blogPost->getTags()) {
            foreach ($blogPost->getTags() as $postTag) {
                $dataTags[] = $postTag->getTag();
                $originalTags->add($postTag);
            }
        }

        $form = $this->createForm(BlogType::class, $blogPost, ['dataTags' => $dataTags]);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        // Check is valid
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->request->get('blog');
            if (isset($data['tags'])) {
                foreach ($data['tags'] as $tadId) {
                    $tag = $this->getDoctrine()
                            ->getRepository('BlogBundle:Tags')
                            ->findOneById($tadId);
                    if ($tag) {
                        $postTag = $this->getDoctrine()
                                ->getRepository('BlogBundle:BlogPostTags')
                                ->findOneBy(['tag' => $tag, 'blogPost' => $blogPost]);
                        if (!$postTag) {
                            $postTag = new BlogPostTags();
                            $postTag->setTag($tag);
                            $postTag->setBlogPost($blogPost);
                            $em->persist($postTag);
                            $blogPost->addTag($postTag);
                        }
                        $originalTags->removeElement($postTag);
                    }
                }
            }
          //  dump($originalTags);
            foreach ($originalTags as $blogTag) {
               // dump($blogPost->getTags()->contains($blogTag));
                $blogPost->removeTag($blogTag);
                $em->remove($blogTag);
            }//exit;
            $blogPost->setUrl(strtolower($blogPost->getUrl()));
            $em->persist($blogPost);
            $em->flush($blogPost);

            $this->addFlash('success', 'Congratulations! Your post is edited.');

            // return $this->redirectToRoute('blog_homepage');

            $url = $this->generateUrl('blog_edit', [ 'id' => $blogPost->getSecureId()]);

            return $this->redirect($url);
        }

        return [
            'form' => $form->createView()
        ];
    }

}
