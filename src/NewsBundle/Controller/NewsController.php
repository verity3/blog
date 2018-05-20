<?php

namespace NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use NewsBundle\Form\NewsType;
use NewsBundle\Entity\NewsPost;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * 
 *
 * @author  Rosana Pencheva <rossana.russeva@gmail.com>
 * 
 * @Security("has_role('ROLE_USER')")
 * 
 */
class NewsController extends Controller {

    /**
     * @Route("/news", name="news_homepage")
     * @Template()
     */
    public function indexAction(Request $request) {
        $user = $this->getUser();
        $query = $this->getDoctrine()
                ->getRepository('NewsBundle:NewsPost')
                ->createQueryBuilder('t')
                ->leftJoin('t.createdBy', 'c')
                ->where('c.id=:userId')
                ->setParameter('userId', $user->getId())
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
     * @Route("/create/news", name="news_create")
     * @Template()
     */
    public function createAction(Request $request) {
        $newsPost = new NewsPost();

        $form = $this->createForm(NewsType::class, $newsPost);
        $form->handleRequest($request);

        // Check is valid
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $newsPost->setCreatedBy($this->getUser());
            //multiple files
            $attachments = $newsPost->getFiles();
            if ($attachments) {
                foreach ($attachments as $attachment) {
                    $file = $attachment->getFile();

                    // var_dump($attachment);
                    $filename = md5(uniqid()) . '.' . $file->guessExtension();

                    $file->move(
                            $this->getParameter('upload_path'), $filename
                    );
                    $filename = '../upload/' . $filename;
                    $attachment->setFile($filename);
                    $em->persist($attachment);
                }
            }

            $em->persist($newsPost);
            $em->flush($newsPost);

            $this->addFlash('success', 'Congratulations! Your post is created');

            $url = $this->generateUrl('news_homepage');

            return $this->redirect($url);
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/publish/{id}/news", name="news_publish")
     * @Method("GET")
     */
    public function publishAction(Request $request, $id) {
        $newsPost = $this->getDoctrine()
                ->getRepository('NewsBundle:NewsPost')
                ->findOneBySecureId($id);
        if ($newsPost) {
            $newsPost->setActive(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($newsPost);
            $em->flush($newsPost);
            $this->addFlash('success', 'Congratulations! Your post is published');
        }
        $url = $this->generateUrl('news_homepage');
        return $this->redirect($url);
    }

    /**
     * @Route("/delete/{id}/news", name="news_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id) {
        $newsPost = $this->getDoctrine()
                ->getRepository('NewsBundle:NewsPost')
                ->findOneBySecureId($id);
        if ($newsPost) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($newsPost);
            $em->flush($newsPost);
            $this->addFlash('success', 'Your post is deleted!');
        }
        $url = $this->generateUrl('news_homepage');
        return $this->redirect($url);
    }

    /**
     * @Route("/download/{id}/news", name="news_download")
     * @Method("GET")
     */
    public function pdfAction(Request $request, $id) {
        $post = $this->getDoctrine()
                ->getRepository('NewsBundle:NewsPost')
                ->findOneBySecureId($id);
        if ($post) {
            $html = $this->renderView('NewsBundle:frontend:pdf.html.twig', array(
                'post' => $post,
                'base_dir' => $this->get('kernel')->getRootDir() . '/../web' . $request->getBasePath()
            ));

            $filename = $post->getTitle() . date("YmdHs") . '.pdf';

            return new Response(
                    $this->get('knp_snappy.pdf')->getOutputFromHtml($html), 200, array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"'
                    )
            );
        } else {
            $this->addFlash('success', 'The news does not exist!');
            $url = $this->generateUrl('news_homepage');
            return $this->redirect($url);
        }
    }

}
