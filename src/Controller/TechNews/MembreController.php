<?php
/**
 * Created by PhpStorm.
 * User: connector
 * Date: 05/12/2018
 * Time: 12:07
 */

namespace App\Controller\TechNews;


use App\Entity\Membre;
use App\Membre\MembreType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MembreController extends AbstractController
{
    /**
     * @Route("inscription", methods={"GET","POST"}, name="membre_inscription")
     * @param Request $request
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function inscription(Request $request, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $membre = new Membre();
        $form= $this->createForm(MembreType::class,$membre)
            ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {

            $membre->setPassword($userPasswordEncoder->encodePassword($membre,$membre->getPassword()));


            $em= $this->getDoctrine()->getManager();
            $em->persist($membre);
            $em->flush();

            $this->addFlash('notice','Félicitation, vous pouvez vous connecter');

            return $this->redirectToRoute('security_connexion');


    }
        return $this->render('membre/inscription.html.twig',[
            'form' => $form->createView()
        ]);


    }
}