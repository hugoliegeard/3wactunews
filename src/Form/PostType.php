<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Saisissez le titre',
                'attr' => [
                    'placeholder' => 'Saisissez le titre',
                ]
            ])
            /*->add('slug', TextType::class, [
                'label' => 'Saisissez un alias',
                'attr' => [
                    'placeholder' => 'Saisissez un alias',
                ]
            ])*/
            ->add('content', TextareaType::class, [
                'label' => 'Saisissez votre article'
            ])
            ->add('imageFile',FileType::class, [
                'label' => "Illustration de l'article",
                # imageFile n'existe pas dans l'entité "POST"
                'mapped' => false,
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            /*->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'firstname',
            ])*/
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer mon article',
                'attr' => [
                    'class' => 'btn w-100 btn-outline-dark'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
