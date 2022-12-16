<?php

namespace App\Controller;

use App\Controller\BController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends BController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        return $this->redirectToRoute('consultation_index');
    }
}
