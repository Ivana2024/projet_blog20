<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\Post;
use App\Entity\User;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

 class PostFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title',TextType::class)
        ->add('category', EntityType::class, [
            'class' => Category::class,
            'choice_label' => 'name',
            'placeholder' =>  'Choisissez la catégorie',
        ])
        ->add('tags', EntityType::class, [
            'class' => Tag::class,
            'choice_label' => 'name',
            'expanded'	=> false,
            'multiple' => true
        ])
            ->add('description',TextType::class,[
                'required' => false,
                
                // 'delete_label' => 'Supprimer', 
                // 'download_label' => false,
                // 'download_uri' => false,
                // 'image_uri' => false,
                // 'imagine_pattern' => false,
                // 'asset_helper' => false,
            ])
            ->add('imageFile',VichImageType::class)
            ->add('content', TextareaType::class )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
