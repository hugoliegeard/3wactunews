<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default_home', methods: ['GET'])]
    public function home(): Response
    {
        # return new Response("<html><body><h1>Hello World!</h1></body></html>");
        return $this->render('default/home.html.twig');
    }

    #[Route('/accueil', name: 'default_accueil', methods: ['GET'])]
    public function accueil(): Response
    {
        return new RedirectResponse('/');
    }

    # -- Routes / Pages pour mes catégories

    #[Route('/{aliasDeMaCategorie}', name: 'default_category', methods: ['GET'])]
    public function category($aliasDeMaCategorie = null): Response
    {
        return $this->render('default/category.html.twig');
    }


}


