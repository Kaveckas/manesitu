<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AccessToken;
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
        $user = $repository->findOneBy([
            'email' => $email,
            'password' => $password,
        ]);
        if (!$user) {
            return new JsonResponse([
                'response' => 'error',
                'error_msg' => 'User not found',
            ]);
        }

        // Generate token
        $token = new AccessToken();
        $token
            ->setToken(md5(uniqid() . $password))
            ->setUser($user)
            ->setCreatedAt(new \DateTime());

        $this->getDoctrine()->getManager()->persist($token);
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse([
            'response' => 'success',
            'token' => $token->getToken(),
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
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('AppBundle:User');
        if ($repository->findOneBy(['email' => $user->getEmail()])) {
            return new JsonResponse([
                'response' => 'error',
                'error_msg' => 'email taken',
            ]);
        }
        $user->setCreatedAt(new \DateTime());
        $em = $doctrine->getManager();
        $em->persist($user);
        $token = $this->container->get('security.token_storage')
            ->getToken()
            ->getSecret();
        $accessToken = new AccessToken();
        $accessToken->setToken($token)
            ->setUser($user)
            ->setCreatedAt(new \DateTime());
        $em->persist($accessToken);
        try {
            $em->flush();
        } catch (\Exception $e) {
            return new JsonResponse([
                'response' => 'error',
                'error_msg' => 'server error',
            ]);
        }
        return new JsonResponse([
            'response' => 'success',
            'data' => $accessToken->getToken(),
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/register-anonymously")
     * @Method("POST")
     */
    public function registerAnonymouslyAction(Request $request)
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
        $doctrine = $this->getDoctrine();
        $user->setCreatedAt(new \DateTime());
        $em = $doctrine->getManager();
        $em->persist($user);
        $token = $this->container->get('security.token_storage')
            ->getToken()
            ->getSecret();
        $accessToken = new AccessToken();
        $accessToken->setToken($token)
            ->setUser($user)
            ->setCreatedAt(new \DateTime());
        $em->persist($accessToken);
        try {
            $em->flush();
        } catch (\Exception $e) {
            return new JsonResponse([
                'response' => 'error',
                'error_msg' => 'server error',
            ]);
        }
        return new JsonResponse([
            'response' => 'success',
            'data' => $user->getAccessToken(),
        ]);
    }
}
