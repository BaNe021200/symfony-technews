<?php
/**
 * Created by PhpStorm.
 * User: connector
 * Date: 07/12/2018
 * Time: 14:10
 */

namespace App\Newletter;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class NewsletterSuscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */

    private $session;

    /**
     * NewsletterSuscriber constructor.
     * @param $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public static function getSubscribedEvents()
    {
        return [

            KernelEvents::REQUEST=>'onKernelRequest',
            KernelEvents::RESPONSE=>'onKernelResponse'

        ];
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest() || $event->getRequest()->isXmlHttpRequest()) {
            // don't do anything if it's not the master request
            return;
        }
        #incrémentation du nombre de pages visitées par mon utilisateur
        $this->session->set('countVisitedPages', $this->session->get('countVisitedPages',0)+1);

        #inviter utilisateur

        if($this->session->get('countVisitedPages')===3){
            $this->session->set('inviteUserModal',true);
        }

        #infoServer

        $request= new Request();

        $requeteDate = $request->server->get('HTTP_HOST');

        dump($requeteDate);

    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (!$event->isMasterRequest() || $event->getRequest()->isXmlHttpRequest()) {
            // don't do anything if it's not the master request
            return;
        }
        $this->session->set('inviteUserModal',false);
    }

}