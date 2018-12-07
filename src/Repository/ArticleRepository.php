<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Event\SchemaColumnDefinitionEventArgs;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    const Max_Results = 5;
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    /*public function findByDirname($dirname)
    {
        return $this->createQueryBuilder('query')
            ->andWhere('query.dirname = :dir')
            ->setParameter('dir', $dirname)
            ->orderBy('query.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;






    }*/


    public function findLatestArticles()
    {

        return $this->createQueryBuilder('a')
            ->orderBy('a.id','DESC')
            ->setMaxResults(self::Max_Results)
            ->getQuery()
            ->getResult();

    }

    public function findArticlesSuggestion($idArticle,$idCategorie)
    {
       #tous les article d'une catégorie ($idCategorie)
        #sauf un article ($idArticle)
        #3 articles max


        return $this->createQueryBuilder('a')
            ->where('a.categorie= :categorie_id')->setParameter('categorie_id',$idCategorie)
            ->andWhere('a.id != :article_id')->setParameter('article_id',$idArticle)
            ->orderBy('a.dateCreation','DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();

    }

    public function findSpotlightArticles()
    {
        return $this->createQueryBuilder('a')
            ->where('a.spotlight =1')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(self::Max_Results)
            ->getQuery()
            ->getResult();

    }

    public function findSpecialArticles()
    {
        return $this->createQueryBuilder('a')
            ->where('a.special =1')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(self::Max_Results)
            ->getQuery()
            ->getResult();

    }


}
