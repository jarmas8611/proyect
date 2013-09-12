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
use Symfony\Component\Security\Core\SecurityContext;
use JMS\SecurityExtraBundle\Security\Authorization\Expression\Expression;
use Taskeet\MainBundle\Entity\Department;
use Taskeet\MainBundle\Entity\Project;

class AddFollowersFieldSubscriber implements EventSubscriberInterface
{
    private $factory, $sc;

    public function __construct(FormFactoryInterface $factory, SecurityContext $sc )
    {
        $this->factory = $factory;
        $this->sc = $sc;

    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_BIND     => 'preBind'
        );
    }

    private function addFollowersForm($form)
    {
        $sc = $this->sc;

        $form->add($this->factory->createNamed('followers', 'double_list',null, array(
            'class'         => 'TaskeetMainBundle:User',
            'label'         => 'Asignado a',
            'empty_value'   => 'Seleccione un usuario',
            'query_builder' => function (EntityRepository $repository) use ($sc) {

                $qb = $repository->createQueryBuilder('user');

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

        $departament = ($data->getDepartment()) ? $data->getDepartment() : null ;
        $this->addFollowersForm($form);
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $departament = array_key_exists('department', $data) ? $data['department'] : null;
        $this->addFollowersForm($form);
    }
}