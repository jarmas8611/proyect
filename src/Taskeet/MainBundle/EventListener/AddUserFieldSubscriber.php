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
use Taskeet\MainBundle\Entity\Department;
use Symfony\Component\Security\Core\SecurityContext;
use JMS\SecurityExtraBundle\Security\Authorization\Expression\Expression;

class AddUserFieldSubscriber implements EventSubscriberInterface
{
    private $factory, $sc;

    public function __construct(FormFactoryInterface $factory, SecurityContext $sc)
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

    private function addUserForm($form, $department)
    {
        $sc = $this->sc;

        $form->add($this->factory->createNamed('assignedTo','entity', $department, array(
            'class'         => 'TaskeetMainBundle:User',
            'label'         => 'Asignado a',
            'empty_value'   => 'Seleccione un usuario',
            'query_builder' => function (EntityRepository $repository) use ($sc, $department) {

                if ($sc->isGranted(array(new Expression('hasRole("ROLE_ADMIN")')))) {
                    $qb = $repository->createQueryBuilder('user');
                }
                elseif($sc->isGranted(array(new Expression('hasRole("ROLE_JEFE_DPTO")')))) {
                    $qb = $repository->createQueryBuilder('user')
                        ->innerJoin('user.department', 'department')
                        ->innerJoin('user.jefeDpto', 'jefe');
                    if ($department instanceof Department) {
                        $qb->where('department = :department')
                           ->orWhere('jefe = :department')
                            ->setParameters(array(
                                'department' => $department,
                                'jefe' => $department,
                            ));
                    } elseif (is_numeric($department)) {
                        $qb->where('department = :department')
                            ->orWhere('jefe.id = :department')
                            ->setParameters(array(
                                'department' => $department,
                                'jefe' => $department,
                            ));
                    } else {
                        $qb->where('department.name = :department')
                            ->setParameter('department', null);
                    }
                }
                else {
                    $qb = $repository->createQueryBuilder('user')
                        ->innerJoin('user.department', 'department')
                        ->innerJoin('user.jefeDpto', 'jefe')
                        ->where('user.id = ?1')
                        ->orWhere('department.owner = jefe')
                        ->setParameter(1, $sc->getToken()->getUser()->getId());
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

        $department = ($data->getDepartment()) ? $data->getDepartment() : null ;
        $this->addUserForm($form, $department);
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $department = array_key_exists('department', $data) ? $data['department'] : null;
        $this->addUserForm($form, $department);
    }
}