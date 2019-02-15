<?php
/**
 * Created by PhpStorm.
 * User: connector
 * Date: 07/12/2018
 * Time: 17:11
 */

namespace App\Membre;


use App\Entity\Membre;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class MembreSuscriber implements EventSubscriberInterface
{
    private $em;

    /**
     * MembreSuscriber constructor.
     * @param $em
     */
    public function __construct(ObjectManager $manager)
    {
        $this->em = $manager;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return[
            SecurityEvents::INTERACTIVE_LOGIN=>'onSecurityInteractiveLogin'
        ];
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        #recup de l'utilisateur
        $membre = $event->getAuthenticationToken()->getUser();

        if($membre instanceof Membre){
            $membre->setDerniereConnection();
            $this->em->flush();
        }
    }
}