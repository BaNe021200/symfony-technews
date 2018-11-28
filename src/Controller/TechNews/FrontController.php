<?php


namespace App\Controller\TechNews;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends Controller
{
    public function index()
    {
        return $this->render('front/index.html.twig');
       #return new Response("<html><body><h1>Page d'accueil</h1></body></html>");
    }

    /**
     * Page permettant d'afficher les articles d'une catégorie
     * @Route("/categorie/{slug<[a-zA-Z1-9\-_\/]+>}",
     *     name="index_categorie",
     *     defaults={"slug":"politique"},
     *     methods={"GET"}
     *
     *     )
     * @param $slug
     * @return Response
     */
    public function categorie($slug)
    {
        return $this->render('front/categorie.html.twig');
        #return new Response("<html><body><h1>Page catégorie : $slug </h1></body></html>");
    }

    /**
     * Afficher un Article
     * @Route("/{categorie<\w+>}/{slug}_{id<\d+>}.html",
     *
     *
     *
     * )
     * @param $id
     * @param $slug
     * @param $categorie
     * @return Response
     */
    public function article($id,$slug,$categorie)
    {
        #politique\Les-gilets-jaune
        #return new Response("<html><body><h1>Page article : $slug </h1></body></html>");
        return $this->render('front/article.html.twig');
    }

}