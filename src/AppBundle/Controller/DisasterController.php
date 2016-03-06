<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DisasterController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/suggest-help", methods={"GET"})
     */
    public function suggestHelpAction(Request $request)
    {
        $data = [
            'info_number' => '8 800 28888'
        ];
        return new JsonResponse($data);
    }
}
