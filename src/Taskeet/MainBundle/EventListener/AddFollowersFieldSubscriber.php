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

    private function addFollowersForm($form, $project)
    {
        $sc = $this->sc;

        $form->add($this->factory->createNamed('followers', 'double_list', null, array(
            'class'         => 'TaskeetMainBundle:User',
            'label'         => 'Seguidores',
            'mapped'        => true,
            'translation_domain' => 'TaskeetMainBundle',
            'query_builder' => function (EntityRepository $repository) use ($sc, $project) {

                if ($sc->isGranted(array(new Expression('hasRole("ROLE_ADMIN")')))) {
                	$qb = $repository->createQueryBuilder('user');
                }
                elseif($sc->isGranted(array(new Expression('hasRole("ROLE_JEFE_DPTO")')))) {
                    $qb = $repository->createQueryBuilder('user')
                        ->innerJoin('user.department', 'department')
                        ->innerJoin('user.projects', 'project');
                    if ($project instanceof Project) {
                        $qb->where('department = :department')
                           ->orWhere('project = :project')
                            ->setParameters(array(
                                'department' => $sc->getToken()->getUser()->getJefeDpto(),
                                'project' => $project,
                            ));
                    } elseif (is_numeric($project)) {
                        $qb->where('department = :department')
                            ->orWhere('project.id = :project')
                            ->setParameters(array(
                                'department' => $sc->getToken()->getUser()->getJefeDpto(),
                                'project' => $project,
                            ));
                    } else {
                        $qb->where('project.name = :project')
                            ->setParameter('project', null);
                    }
                }
                else {
                    $qb = $repository->createQueryBuilder('user')
                        ->andWhere('user.id = ?1')
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

        $project = ($data->getProject()) ? $data->getProject() : null ;
        $this->addFollowersForm($form, $project);
    }

    public function preBind(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $project = array_key_exists('project', $data) ? $data['project'] : null;
        $this->addFollowersForm($form, $project);
    }
}