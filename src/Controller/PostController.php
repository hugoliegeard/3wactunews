<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/administration/article', name: 'post_')]
class PostController extends AbstractController
{

    #[Route('/rediger.html', name: 'add')]
    public function addPost(Request $request, EntityManagerInterface $manager) {

        # Pour créer un formulaire avec Symfony
        # 1. Création d'un nouveau Post
        $post = new Post();

        # 2. Création du formulaire
        $form = $this->createForm(PostType::class, $post);

        # 4. Traitement du formulaire
        $form->handleRequest($request);

        # 5 Vérifie si mon formulaire a bien été soumis et est valide.
        if ($form->isSubmitted() && $form->isValid()) {

            # 6. Enregistrement dans la BDD
            $manager->persist($post);
            $manager->flush();

            # 7. TODO Redirection vers la page de l'article.
        }

        # 3. Passer le formulaire à la vue
        return $this->render('post/add.html.twig', [
            'form' => $form
        ]);

    }
}
