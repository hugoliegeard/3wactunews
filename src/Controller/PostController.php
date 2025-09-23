<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/administration/article', name: 'post_')]
class PostController extends AbstractController
{

    #[Route('/rediger.html', name: 'add')]
    #[IsGranted('ROLE_AUTHOR')]
    public function addPost(Request $request,
                            SluggerInterface $slugger,
                            EntityManagerInterface $manager) {

        # Pour créer un formulaire avec Symfony
        # 1a. Création d'un nouveau Post
        $post = new Post();

        # 1b. Affectation de l'utilisateur connecté en tant qu'auteur de l'article
        $user = $this->getUser();
        $post->setUser($user);

        # 2. Création du formulaire
        $form = $this->createForm(PostType::class, $post);

        # 4. Traitement du formulaire
        $form->handleRequest($request);

        # 5 Vérifie si mon formulaire a bien été soumis et est valide.
        if ($form->isSubmitted() && $form->isValid()) {

            # (OPTION) : Génération du slug (alias)
            $post->setSlug(
                $slugger->slug(
                    $post->getTitle()
                )
            );

            # 6. Enregistrement dans la BDD
            $manager->persist($post);
            $manager->flush();

            # 7. Notification & Redirection vers la page de l'article.
            $this->addFlash("success", "Votre article à bien été publié.");

            # FIXME remplacer par la page ARTICLE (default_post)
            return $this->redirectToRoute('default_home');
        }

        # 3. Passer le formulaire à la vue
        return $this->render('post/add.html.twig', [
            'form' => $form
        ]);

    }
}
