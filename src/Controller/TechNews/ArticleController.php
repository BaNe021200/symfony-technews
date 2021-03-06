<?php
/**
 * Created by PhpStorm.
 * User: connector
 * Date: 30/11/2018
 * Time: 09:56
 */

namespace App\Controller\TechNews;


use App\Article\ArticleType;
use App\Controller\HelperTrait;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Membre;
use App\Repository\MembreRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class ArticleController extends AbstractController
{
    use HelperTrait;

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
     * @Security("has_role('ROLE_AUTEUR')")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @throws \Exception
     */
    public function newArticle(Request $request)
    {
        #recup d'un membre
        #$membre =$this->getDoctrine()->getRepository(Membre::class)
        #->find(1);

        $article = new Article();
        $article->setMembre($this->getUser());
        $form= $this->createForm(ArticleType::class,$article)

        ->handleRequest($request);

       // $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            #
            #1.traitement de l'upload
            // $file stores the uploaded PDF file
            /** @var UploadedFile $featuredImage */

            $featuredImage = $article->getFeaturedImage();

            if(null !== $featuredImage)
            {



                $fileName = $this->slugify($article->getTitre()).'.'.$featuredImage->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $featuredImage->move(
                        $this->getParameter('articles_assets_dir'),
                        $fileName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                # mise à jour de l'image
                $article->setFeaturedImage($fileName);

                # 2. mise à jour du slug

                $article->setSlug($this->slugify($article->getTitre()));

                # 3. sauvegarde en BDD

                $em= $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();
                # 4. notification

                $this->addFlash('notice',"Felicitation votre article est en ligne");

                # 5.redirection vers l'article

                return $this->redirectToRoute('front_article',[
                    'categorie' => $article->getCategorie()->getslug(),
                    'slug' => $article->getSlug(),
                    'id'=>$article->getId()
                ]);
            }else{

                #4. notification

                $this->addFlash('error', "N'oubliez pas de chosir une image d'illustration");
            }



        }

        # affichage du formulaire

        return $this->render('article/form.html.twig',[
            'form'=>$form->createView()

        ]);



    }

    /*
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }*/


    /**
     * @Route("/editArticle/{id<\d+>}",name="edit_article")
     * @Security("article.isAuteur(user)")
     * @param Request $request
     * @param Article $article
     * @param Packages $packages
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
     public function editArticle(Request $request, Article $article,Packages $packages)
     {
        /* $article->getMembre();
         $membre= $this->getUser();

         if ($article == $membre)
         {
             $this->newArticle();

         }*/


            #on passe l'url de feturedimage à notre controler
         $options=[
             'image_url'=>$packages->getUrl('images/music/'.$article->getFeaturedImage())
         ];

           # recup de l'image
         $featuredImageName = $article->getFeaturedImage();

         #notre formulaire attend une instance de File pour l'édition de la featuredImage
        $article->setFeaturedImage(
            new File($this->getParameter('articles_assets_dir').'/'.$article->getFeaturedImage())
        );

        # création /  récup deu formumlaire
        $form= $this->createForm(ArticleType::class,$article,$options)

             ->handleRequest($request);
        # si le formulaire est valide
         if ($form->isSubmitted() && $form->isValid())
         {
             #
             #traitement de l'upload
             // $file stores the uploaded PDF file
             /** @var UploadedFile $featuredImage */

             $featuredImage = $article->getFeaturedImage();
             if (null !== $featuredImage) {

                 $fileName = $this->slugify($article->getTitre())
                     . '.' . $featuredImage->guessExtension();

                 try {
                     $featuredImage->move(
                         $this->getParameter('articles_assets_dir'),
                         $fileName
                     );
                 } catch (FileException $e) {

                 }

                 # Mise à jour de l'image
                 $article->setFeaturedImage($fileName);

             } else {
                 $article->setFeaturedImage($featuredImageName);
             }
             #mise à jour du slug

             $article->setSlug($this->slugify($article->getTitre()));

             #sauvegarde en BDD

             $em= $this->getDoctrine()->getManager();
             $em->persist($article);
             $em->flush();
             #notification
             $this->addFlash('notice',"Felicitation votre article est en ligne");
             #redirection vers l'article

             return $this->redirectToRoute('front_article',[
                 'categorie' => $article->getCategorie()->getslug(),
                 'slug' => $article->getSlug(),
                 'id'=>$article->getId()
             ]);




         }

    return $this->render('article/form.html.twig',[
             'form'=>$form->createView()

         ]);

     }

}