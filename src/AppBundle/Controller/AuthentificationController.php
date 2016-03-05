<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuthentificationController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/login")
     * @Method("POST")
     */
    public function loginAction(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');
        if (!$email) {
            return new JsonResponse([
                'response' => 'error',
                'error_msg' => 'email not provided',
            ]);
        }
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:User');
        $user = $repository->findOneBy(['email' => $email]);
        if (!$user) {
            return new JsonResponse([
                'response' => 'error',
                'error_msg' => 'User nof found',
            ]);
        }
        if ($user->getPassword() !== $password) {
            return new JsonResponse([
                'response' => 'error',
                'error_msg' => 'Wrong password',
            ]);
        };
        return new JsonResponse([
            'response' => 'success',
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/register")
     * @Method("POST")
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        // @TODO: validators
        if (!$form->isValid()) {
            return new JsonResponse([
                'response' => 'error',
                'error_msg' => 'data not provided',
            ]);
        }
        $userArray = $request->get('user');
        if (!isset($userArray['email'])) {
            return new JsonResponse([
                'response' => 'error',
                'error_msg' => 'email not provided',
            ]);
        }
        $email = $userArray['email'];
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return new JsonResponse([
                'response' => 'error',
                'error_msg' => 'email not valid',
            ]);
        }
        if (!isset($userArray['password'])) {
            return new JsonResponse([
                'response' => 'error',
                'error_msg' => 'password not provided',
            ]);
        }
        $password = $userArray['password'];
        if (strlen($password) < 5) {
            return new JsonResponse([
                'response' => 'error',
                'error_msg' => 'password too short',
            ]);
        }
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('AppBundle:User');
        if ($repository->findOneBy(['email' => $email])) {
            return new JsonResponse([
                'response' => 'error',
                'error_msg' => 'email taken',
            ]);
        }
        $user->setEmail($email)
            ->setPassword($password)
            ->setCreatedAt(new \DateTime());
        $em = $doctrine->getManager();
        $em->persist($user);
        $em->flush();
        return new JsonResponse([
            'response' => 'success',
        ]);
    }
}
