<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Post;
use AppBundle\Entity\Reaction;
use AppBundle\Form\CommentType;
use AppBundle\Repository\ReactionRepository;
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
     * @Route("/post/{post}/comments/{page}", defaults={"page"=1})
     */
    public function listAction(Post $post, $page)
    {
        $repository = $this->getDoctrine()->getRepository(Comment::class);
        $comments = $repository->getPagedList($post->getId(), $page);

        $postData = null;

        if ($page === 1) {
            /** @var ReactionRepository $reactionRepository */
            $reactionRepository = $this->getDoctrine()->getManager()->getRepository(Reaction::class);

            $postData = [
                'id' => $post->getId(),
                'content' => $post->getContent(),
                'created_at' => $post->getCreatedAt()->format(DATE_ISO8601),
                'author' => $post->getAuthor()->getName(),
                'comments' => count($post->getComments()),
                'reactions' => $reactionRepository->getCountsByPost($post->getId()),
            ];
        }

        return new JsonResponse(array_filter([
            'post' => $postData,
            'comments' => $comments,
        ]));
    }
}
