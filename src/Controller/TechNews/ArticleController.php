<?php
/**
 * Created by PhpStorm.
 * User: connector
 * Date: 30/11/2018
 * Time: 09:56
 */

namespace App\Controller\TechNews;


use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Membre;
use App\Repository\MembreRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends Controller
{
    /**
     * démo ajout article avec doctrine
     * @Route("test/ajouter-un-article",name="article_test")
     */
    public function test()
    {
        $categorie= (new Categorie())->setNom('Politique')->setSlug('politique');
        $membre = (new Membre())
            ->setNom('Paul')
            ->setPrenom('Doe')
            ->setEmail('paulo@mail.com')
            ->setPassword('test')
            ->setRole(['ROLE_AUTEUR']);

        $article = (new Article())
            ->setTitre('Les Beatles en concert sur le toit d\'Apple')
            ->setSlug('Les-Beatles-en-concert-sur-le-toit-d-Apple')
            ->setContenu('Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod')
            ->setFeaturedImage('1.jpg')
            ->setSpotlight(0)
            ->setSpecial(1)
            ->setCategorie($categorie)
            ->setMembre($membre);


        $em =$this->getDoctrine()->getManager();
        $em->persist($categorie);
        $em->persist($membre);
        $em->persist($article);
        $em->flush();

        return new Response('Nouvel Article Id '
            .$article->getId()
            .$categorie->getNom()
            .' de l\'auteur :'
            .$membre->getPrenom()


        );

    }


    /**
     * @Route("/newArticle",name="new_article")
     */
    public function newArticle(Request $request)
    {
        $membre =$this->getDoctrine()->getRepository(Membre::class)
        ->find(2);

        $article = new Article();
        $article->setMembre($membre);
        $form= $this->createFormBuilder($article)
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
                'label'=> "images",
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



            ])
        ->getForm();



        return $this->render('article/form.html.twig',[
            'form'=>$form->createView()

        ]);



    }
}