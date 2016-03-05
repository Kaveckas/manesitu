<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * @Route("/post/add", methods={"post"})
     */
    public function addPostAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(new PostType(), $post);
        $form->handleRequest($request);

        if ($form->isValid()) {
            // TODO: assign user
            $post->setCreatedAt(new \DateTime());

            $this->getDoctrine()->getManager()->persist($post);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(['id' => $post->getId()], Response::HTTP_CREATED);
        }

        // TODO: return errors list
        return new JsonResponse(['errors' => true]);
    }

    /**
     * @Route("/posts/{page}", defaults={"page"=1})
     */
    public function listAction($page)
    {
        $repository = $this->getDoctrine()->getRepository(Post::class);
        $posts = $repository->getPagedList($page);

        return new JsonResponse([
            'posts' => $posts,
        ]);
    }
}
