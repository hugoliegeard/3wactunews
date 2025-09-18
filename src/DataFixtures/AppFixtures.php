<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        # Création d'un utilisateur
        $user = new User();
        $user->setEmail('hugo@actunews.com')
            ->setFirstName('Hugo')
            ->setLastName('Doe')
            ->setPassword('demo')
            ->setRoles(['ROLE_USER']);

        # Sauvegarde de l'utilisateur
        $manager->persist($user);

        # Création des catégories
        $politique = new Category();
        $politique->setName('Politique');
        $politique->setSlug('politique');

        $economie = new Category();
        $economie->setName('Economie');
        $economie->setSlug('economie');

        $culture = new Category();
        $culture->setName('Culture');
        $culture->setSlug('culture');

        $loisirs = new Category();
        $loisirs->setName('Loisirs');
        $loisirs->setSlug('loisirs');

        $sport = new Category();
        $sport->setName('Sport');
        $sport->setSlug('sport');

        # Sauvegarde des éléments
        $manager->persist($politique);
        $manager->persist($economie);
        $manager->persist($culture);
        $manager->persist($loisirs);
        $manager->persist($sport);

        # Création d'un tableau de catégories
        $categories = [$politique, $economie, $culture, $loisirs, $sport];

        # Création des articles
        for ($i = 0; $i < 50; $i++) {
            $post = new Post();
            $post->setTitle("Titre de l'article n°$i")
                ->setSlug("titre-de-l-article-n-$i")
                ->setContent('<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda, iusto maiores minus non rem rerum saepe? Id ipsam molestiae nemo nihil officiis quo ratione reprehenderit sed vel voluptatum! Molestias, nam?</p>')
                ->setImage('https://placehold.co/600x400')
                ->setUser($user)
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable())
                ->setCategory($categories[array_rand($categories)]);

            $manager->persist($post);
        }

        # Déclenche l'enregistrement de toutes les données
        $manager->flush();
    }
}
