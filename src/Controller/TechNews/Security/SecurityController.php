<?php
/**
 * Created by PhpStorm.
 * User: connector
 * Date: 06/12/2018
 * Time: 10:09
 */

namespace App\Controller\TechNews\Security;


use App\Membre\MembreLoginType;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * connexion d'un membre
     * @Route("/connexion",name="security_connexion")
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function connexion(AuthenticationUtils $authenticationUtils)
    {
        /**
         * si l'utilisateur est déjà authentifié, on le redirige sur la page d'acceuil
         */
        if ($this->getUser())
        {
            return $this->redirectToRoute('index');
        }

        #recup formulaire

        $form = $this->createForm(MembreLoginType::class,[
            'email' =>$authenticationUtils->getLastUsername()
        ]);


        // recup du message d'erreur
        $error = $authenticationUtils->getLastAuthenticationError();


        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        #transmissionà la vue
        return $this->render('security/connexion.html.twig', [
            'form'=> $form->createView(),
            'error' => $error
        ]);


    }

    /**
     * deconexion d'un membre
     * @Route("/deconnexion",name="security_deconnexion")
     */
    public function deconnexion()
    {

    }

}