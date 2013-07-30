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
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
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
            $followers = array();
            foreach ($entity->getFollowers() as $key => $value) {
                $followers[] = $value->getEmail();
            }

            $changelog = $args->getEntityChangeSet();

            $body = $this->container->get('templating')->render(
                'TaskeetMainBundle:Default:email.txt.twig',
                array(
                    'entity' => $entity,
                    'changelog'   => $changelog
                )
            );
            $message = \Swift_Message::newInstance()
                ->setSubject("Tarea modificada")
                ->setFrom('no-reply@personaltask.com')
                ->setTo($followers)
                ->setBody($body)
            ;
            $this->container->get('mailer')->send($message);
        }
    }

}