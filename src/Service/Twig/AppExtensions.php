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
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twig\Extension\AbstractExtension;

class AppExtensions extends AbstractExtension
{
    private $em;
    private $session;
    public const NB_SUMMARY_CHAR = 170;

    /**
     * AppExtensions constructor.
     * @param EntityManagerInterface $manager
     * @param SessionInterface $session
     */
    public function __construct(EntityManagerInterface $manager, SessionInterface $session)
    {
        $this->em = $manager;
        $this->session=$session;
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

            }),

            new \Twig_Function('isUserInvited',function (){
                return $this->session->get('inviteUserModal');

            })

        ];
    }





}