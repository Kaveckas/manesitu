<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Entity\User;
use AppBundle\Form\MessageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MessageController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/create-message", methods={"POST"})
     */
    public function createMessageAction(Request $request)
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            // TODO: return errors list
            return new JsonResponse(['errors' => true]);
        }
        $message
            ->setSender($this->getUser())
            ->setCreatedAt(new \DateTime());

        $objectManager = $this->getDoctrine()->getManager();
        $objectManager->persist($message);
        $objectManager->flush();

        return new JsonResponse(['id' => $message->getId()]);
    }

    /**
     * @param User $receiver
     * @return JsonResponse
     * @Route("/messages/{receiver}")
     */
    public function listAction(User $receiver)
    {
        $repository = $this->getDoctrine()->getRepository(Message::class);
        $messages = $repository->getList($receiver->getId());
        return new JsonResponse([
            'messages' => $messages,
        ]);
    }
}
