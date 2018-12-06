<?php
/**
 * Created by PhpStorm.
 * User: connector
 * Date: 05/12/2018
 * Time: 10:39
 */

namespace App\Article;


use App\Entity\Article;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class,[
        'required'=>true,
        'label'=> "titre de l'article",
        'attr'=>[
            'placeholder'=>"titre de l'article"
        ]


    ])->add('categorie',EntityType::class,[
        'class'=>Categorie::class,
        'choice_label'=>'nom',
        'expanded'=>false,
        'multiple'=>false,
        'label'=>"Catégories",


    ])


        ->add('contenu', CKEditorType::class,[
            'required'=>true,
            'label'=> "Contenu",
            'attr'=>[
                'placeholder'=>"contenu"
            ],
            'config' =>[
                'toolbar'=>'standard'
            ]


        ])
        ->add('featuredImage', FileType::class,[
            'required'=>true,
            'label'=> 'FeaturedImage (Jpg file)',
            'attr'=>[
                'class'=>"dropify"
            ]


        ])
        ->add('special', CheckboxType::class,[

            'required'=>false,

            'attr'=>[
                'data-toggle'=>"toggle",
                'data-on'=> 'oui',
                'data-off'=>'non',
            ]


        ])
        ->add('spotlight', CheckboxType::class,[

            'required'=>false,

            'attr'=>[
                'data-toggle'=>"toggle",
                'data-on'=> 'oui',
                'data-off'=>'non',
            ]


        ])

        ->add('submit', SubmitType::class,[
            'label'=> "submit",



        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
       $resolver->setDefaults([
           'data_class' => Article::class

       ]);
    }


}