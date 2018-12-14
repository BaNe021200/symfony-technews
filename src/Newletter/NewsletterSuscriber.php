<?php
namespace App\Newletter;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class NewsletterSuscriber implements EventSubscriberInterface
{

    private $session;

    /**
     * NewsletterSuscriber constructor.
     * @param $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }


    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return[

            KernelEvents::REQUEST =>'onKernelRequest',
            KernelEvents::RESPONSE=> 'onKernelResponse'

        ];
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest() || $event->getRequest()->isXmlHttpRequest())  {

            return;
        }
        $this->session->set('countVisitedPages',$this->session->get('countVisitedPages',0)+1);
        if ($this->session->get('countVisitedPages')===3)
        {
            $this->session->set('inviteUserModal',true);
        }
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (!$event->isMasterRequest() || $event->getRequest()->isXmlHttpRequest()) {

            return;
        }

        $this->session->set('inviteUserModal',false);

    }
}