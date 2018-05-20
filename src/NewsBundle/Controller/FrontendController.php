<?php

namespace NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use NewsBundle\Form\NewsType;
use NewsBundle\Entity\NewsPost;

/**
 * Description of FrontendController
 *
 * @author Rosana Pencheva <rossana.russeva@gmail.com>
 */
class FrontendController extends Controller {

    /**
     * @Route("/", name="frontend_homepage")
     * @Template()
     */
    public function indexAction(Request $request) {
        $posts = $this->getDoctrine()
                ->getRepository('NewsBundle:NewsPost')
                ->createQueryBuilder('t')
                ->where('t.active = :active')
                ->setParameter('active', true)
                ->orderBy('t.date', 'DESC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult();

        return[
            'posts' => $posts,
        ];
    }

    /**
     * @Route("/show/{id}", name="frontend_show_post")
     * @Template()
     */
    public function showAction($id) {
        $post = $this->getDoctrine()
                ->getRepository('NewsBundle:NewsPost')
                ->findOneBySecureId($id);
        if (!$post) {
            throw $this->createNotFoundException('Unable to find entity.');
        }

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
