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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
}