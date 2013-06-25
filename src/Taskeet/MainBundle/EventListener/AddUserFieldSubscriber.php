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
use Taskeet\MainBundle\Entity\Project;

class AddUserFieldSubscriber implements EventSubscriberInterface
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

    private function addUserForm($form, $project)
    {
        $form->add($this->factory->createNamed('assignedTo','entity', null, array(
            'class'         => 'TaskeetMainBundle:User',
            'label'         => 'Asignado a',
            'empty_value'   => 'Seleccione un usuario',
            'query_builder' => function (EntityRepository $repository) use ($project) {
                $qb = $repository->createQueryBuilder('user')
                    ->innerJoin('user.projects', 'project');
                if ($project instanceof Project) {
                    $qb->where('user.projects = :project')
                        ->setParameter('project', $project);
                } elseif (is_numeric($project)) {
                    $qb->where('project.id = :project')
                        ->setParameter('project', $project);
                } else {
                    $qb->where('project.name = :project')
                        ->setParameter('project', null);
                }

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
        $this->addUserForm($form, $project);
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $project = array_key_exists('project', $data) ? $data['project'] : null;
        $this->addUserForm($form, $project);
    }
}