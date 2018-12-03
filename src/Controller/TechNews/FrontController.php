<?php


namespace App\Controller\TechNews;


use App\Entity\Article;
use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Article\Provider\YamlProvider;

class FrontController extends Controller
{
    public function index(YamlProvider $yamlProvider)
    {

       #return new Response("<html><body><h1>Page d'accueil</h1></body></html>");
        #récupération  des articles depuis le yamlprovider
        #
        #$articles = $yamlProvider->getArticles();
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $articles = $repository->findBy([],['id' =>'DESC']);
        $spotlight = $repository->findSpotlightArticles();
        $special= $repository->findSpecialArticles();



        return $this->render('front/index.html.twig',[
            'articles' => $articles,
            'spotlight'=>$spotlight,
            'special' =>$special
        ]);
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
     * @param Categorie|null $categorie
     * @return Response
     */
    public function categorie($slug, Categorie $categorie = null)
    {
        #methode1
         #   $categorie = $this->getDoctrine()
         #       ->getRepository(Categorie::class)
         #       ->findOneBy('slud',$slug);

         #   $articles = $categorie->getArticles();

        #methode 2

        #$articles = $this->getDoctrine()
        #    ->getRepository(Categorie::class)
        #    ->findOneBySlug($slug)
        #    ->getArticles();

        #methode 3

        dump($this->article());
        return $this->render('front/categorie.html.twig',[
            'articles' =>$categorie->getArticles()


        ]);
        #return new Response("<html><body><h1>Page catégorie : $slug </h1></body></html>");
    }

    /**
     * Afficher un Article
     * @Route("/{categorie<\w+>}/{slug}_{id<\d+>}.html",name="front_article"
     *
     *
     *
     * )
     * @param $id
     *
     * @param $slug
     * @param $categorie
     * @param Article|null $article
     * @return Response
     */
    public function article( $id,$slug,$categorie, Article $article = null )
    {
        #politique\Les-gilets-jaune
        #return new Response("<html><body><h1>Page article : $slug </h1></body></html>");
        #$article= $this->getDoctrine()
        #    ->getRepository(Article::class)
        #   ->find($id);

        if (null===$article){
        #    throw new $this->createNotFoundException("nous n'avons pas trouvé votre artice ID");
        return $this->redirectToRoute('index',[],Response::HTTP_MOVED_PERMANENTLY);

        }

        #Verif du slug

        if ($article->getSlug() !== $slug
            ||$article->getCategorie()->getSlug() !== $categorie)
        {
            return $this->redirectToRoute('front_article',[

                'categorie' => $article->getCategorie()->getSlug(),
                'slug'=> $article->getSlug(),
                'id'=>$id


            ]);
        }

        #recup suggestion

        $suggestions = $this->getDoctrine()->getRepository(Article::class)
            ->findArticlesSuggestion($article->getId(), $article->getCategorie()->getId());


        return $this->render('front/article.html.twig',[
            'article' => $article,
            'suggestions' => $suggestions

        ]);
    }







}