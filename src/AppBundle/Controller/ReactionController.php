<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Reaction;
use AppBundle\Form\ReactionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReactionController extends Controller
{
    /**
     * @Route("/reaction/add")
     */
    public function addAction(Request $request)
    {
        $reaction = new Reaction();
        $form = $this->createForm(ReactionType::class, $reaction);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $reaction
                ->setUser($this->getUser())
                ->setCreatedAt(new \DateTime());

            $this->getDoctrine()->getManager()->persist($reaction);
            $this->getDoctrine()->getManager()->flush();

            return new JsonResponse(['id' => $reaction->getId()], Response::HTTP_CREATED);
        }

        // TODO: return errors list
        return new JsonResponse(['errors' => true]);
    }
}
