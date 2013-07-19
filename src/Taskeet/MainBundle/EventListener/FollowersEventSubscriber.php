<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rafix
 * Date: 17/07/13
 * Time: 22:57
 * To change this template use File | Settings | File Templates.
 */

namespace Taskeet\MainBundle\EventListener;

use Doctrine\Common\EventSubscriber;
//use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Taskeet\MainBundle\Entity\Ticket;


class FollowersEventSubscriber implements EventSubscriber
{
    private $mailer;

    public function __construct($mailer)
    {
        $this->mailer = $mailer;
    }

    public function getSubscribedEvents()
    {
        return array(
            'preUpdate',
        );
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();


        if ($entity instanceof Ticket) {
            $message = \Swift_Message::newInstance()
                ->setSubject('Hello Email')
                ->setFrom('send@example.com')
                ->setTo('recipient@example.com')
                ->setBody(
                    $this->renderView(
                        'HelloBundle:Hello:email.txt.twig',
                        array('name' => $name)
                    )
                )
            ;
            $mailer->send($message);
        }
    }

}