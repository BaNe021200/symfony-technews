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
    public const NB_SUMMARY_CHAR = 170;

    /**
     * AppExtensions constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
    }

    public function getFilters()
    {
        return [
            new \Twig_Filter('summary', function ($text){
                #Suppression des balises HTML
                $string = strip_tags($text);
                if (strlen($string)>self::NB_SUMMARY_CHAR){
                  $stringCut = substr($string,0,self::NB_SUMMARY_CHAR);
                  $string = substr($stringCut,0,strpos($stringCut, ' ')).'...';
                }
                return $string;
            }, ['is_safe' =>['html']])
        ];
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