<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rafix
 * Date: 13/06/13
 * Time: 16:01
 * To change this template use File | Settings | File Templates.
 */

namespace Taskeet\MainBundle\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityRepository;

class AddFollowersFieldSubscriber implements EventSubscriberInterface
{
	private $factory, $container;

    public function __construct(FormFactoryInterface $factory, $container)
    {
        $this->factory = $factory;
        $this->container = $container;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_BIND     => 'preBind'
        );
    }

    private function addFollowersForm($form, $followers)
    {
        $form->add($this->factory->createNamed('followers', 'double_list', null, array(
            'class'         => 'TaskeetMainBundle:User',
            'label'         => 'Seguidores',
            'mapped'        => true,
            'translation_domain' => 'TaskeetMainBundle',
            'query_builder' => function (EntityRepository $repository) use ($followers) {
                $usuario = $this->container->get('security.context')->getToken()->getUser();
                if ($usuario->getUsername() == 'rafix') {
                	$qb = $repository->createQueryBuilder('user');
                }
                else
                	$qb = null;

                return $qb;
            }
        )));
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $followers = ($data->getFollowers()) ? $data->getFollowers() : null ;
        $this->addFollowersForm($form, $followers);
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $followers = array_key_exists('followers', $data) ? $data['followers'] : null;
        $this->addFollowersForm($form, $followers);
    }
}