<?php

namespace App\Controller;


use App\Entity\Category;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default_home', methods: ['GET'])]
    public function home(PostRepository $postRepository): Response
    {

        # Récupération des 6 derniers articles, ordonnés par date de création décroissante
        $posts = $postRepository->findBy([], ['createdAt' => 'DESC'], 6);

        # Affichage de la vue et passage de la variable "posts"
        return $this->render('default/home.html.twig', [
            'posts' => $posts,
        ]);
    }

    # -- Routes / Pages pour mes catégories

    #[Route('/{slug:category}', name: 'default_category', methods: ['GET'])]
    public function category(Category $category): Response
    {
        # Récupération de la catégorie automatiquement : https://symfony.com/doc/current/doctrine.html#fetch-automatically
        # Passer a ma vue la catégorie
        return $this->render('default/category.html.twig', [
            'category' => $category,
        ]);
    }


}


