<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController
{
    #[Route('/', name: 'default_home', methods: ['GET'])]
    public function home(): Response
    {
        return new Response("<html><body><h1>Hello World!</h1></body></html>");
    }

    #[Route('/accueil', name: 'default_accueil', methods: ['GET'])]
    public function accueil(): Response
    {
        return new RedirectResponse('/');
    }
}


