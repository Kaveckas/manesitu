<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommentsController extends Controller
{
    /**
     * @Route("/comment/add", methods={"post"})
     */
    public function addCommentAction(Request $request)
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            // TODO: return errors list
            return new JsonResponse(['errors' => true]);
        }
        $comment
            ->setAuthor($this->getUser())
            ->setCreatedAt(new \DateTime());

        $objectManager = $this->getDoctrine()->getManager();
        $objectManager->persist($comment);
        $objectManager->flush();

        return new JsonResponse(['id' => $comment->getId()]);
    }

    /**
     * @Route("/post/{postId}/comments/{page}", defaults={"page"=1})
     */
    public function listAction($postId, $page)
    {
        $repository = $this->getDoctrine()->getRepository(Comment::class);
        $comments = $repository->getPagedList($postId, $page);

        return new JsonResponse([
            'comments' => $comments,
        ]);
    }
}
