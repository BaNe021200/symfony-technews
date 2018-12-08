<?php
/**
 * Created by PhpStorm.
 * User: connector
 * Date: 07/12/2018
 * Time: 12:23
 */

namespace App\Controller\TechNews;


use App\Newletter\NewletterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NewsletterController extends AbstractController
{

    public function newsletter()
    {
        $form = $this->createForm(NewletterType::class);
        return $this->render('newletter/_modal.html.twig',[
           'form' =>$form->createView()
        ]);
    }


}