<?php
/**
 * Created by PhpStorm.
 * User: connector
 * Date: 03/12/2018
 * Time: 10:54
 */

namespace App\Service\Twig;


use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;

class AppExtensions extends AbstractExtension
{
    private $em;

    /**
     * AppExtensions constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
    }


    public function getFunctions()
    {



        return [

            new \Twig_Function('getCategories',function (){
               return $this->em->getRepository(Categorie::class)->findCategoriesHavingArticles();

            })

        ];
    }



}