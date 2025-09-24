<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
                            #[Autowire('%kernel.project_dir%/public/uploads/posts')] string $postsDirectory,
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

            # Traitement de l'upload de l'image (SIMPLIFIE)
            # Récupération de l'image uploadé
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('imageFile')->getData();

            # Si une image est bien chargée, alors on commence le processus.
            if ($imageFile) {

                # Le nom de l'image, correspond a l'alias de l'article suivi d'un chiffre aléatoire puis l'extension.
                # ex. nouveau-vote-a-l-assemblee-national-345678.jpg
                $newFilename = $post->getSlug().'-'.uniqid().'.'.$imageFile->guessExtension();

                // Déplacement du fichier depuis tmp vers le dossier /uploads
                try {
                    $imageFile->move($postsDirectory, $newFilename);
                } catch (FileException $e) {
                    # TODO En cas d'erreur traitement ici
                }

                # On ajoute le nom du fichier dans la BDD
                $post->setImage($newFilename);
            }

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
