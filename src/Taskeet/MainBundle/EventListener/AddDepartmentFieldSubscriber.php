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

class AddDepartmentFieldSubscriber implements EventSubscriberInterface
{
    private $factory;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_BIND     => 'preBind'
        );
    }

    private function addProjectForm($form, $department)
    {
        $form->add($this->factory->createNamed('department', 'entity', $department, array(
            'class'         => 'TaskeetMainBundle:Department',
            'label'         => 'Department',
            'mapped'        => true,
            'empty_value'   => 'Seleccione un departamento',
            'query_builder' => function (EntityRepository $repository) {
                $qb = $repository->createQueryBuilder('department');

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

        $project = ($data->getProject()) ? $data->getProject() : null ;
        $this->addProjectForm($form, $project);
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $project = array_key_exists('project', $data) ? $data['project'] : null;
        $this->addProjectForm($form, $project);
    }
}