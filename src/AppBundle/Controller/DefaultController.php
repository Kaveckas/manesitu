<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..'),
        ]);
    }

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
}
