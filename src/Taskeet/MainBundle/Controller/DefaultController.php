<?php

namespace Taskeet\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function welcomeAction()
    {
        $qb = $this->getDoctrine()->getRepository('TaskeetMainBundle:Ticket')->createQueryBuilder('t');

        $today = $qb
            ->where('t.startDate = ?1')
            ->andWhere('t.assignedTo = ?2')
            ->setParameters(array(1 => new \DateTime('today'), 2 => $this->getUser()))
            ->getQuery()->getResult();

        $nextWeek = $qb
            ->where($qb->expr()->between('t.startDate', '?1', '?3'))
            ->andWhere('t.assignedTo = ?2')
            ->setParameters(array(
            1 => new \DateTime('+1 day'),
            2 => $this->getUser(),
            3 => new \DateTime('+1 week')
        ))
            ->getQuery()->getResult();

        $undone = $qb
            ->where('t.dueDate < ?1')
            ->andWhere('t.assignedTo = ?2')
            ->andWhere('t.done = ?3')
            ->setParameters(array(
            1 => new \DateTime('today'),
            2 => $this->getUser(),
            3 => false
        ))
            ->getQuery()->getResult();

        $priority = $qb
            ->leftJoin('t.priority', 'p')
            ->where('t.done = ?1')
            ->andWhere('t.assignedTo = ?2')
            ->orderBy('p.weight', 'DESC')
            ->setMaxResults(10)
            ->setParameters(array(1 => false, 2 => $this->getUser()))
            ->getQuery()->getResult();

        return $this->render('TaskeetMainBundle:Dashboard:welcome.html.twig',
            array(
                'User' => $this->getUser(),
                'today' => $today,
                'nextWeek' => $nextWeek,
                'undone' => $undone,
                'priority' => $priority
            ));
    }

    public function usersAction()
    {
        $department_id = $this->getRequest()->request->get('department_id');

        $em = $this->getDoctrine()->getManager();

        $department = $em->getRepository('TaskeetMainBundle:Department')->find($department_id);

        $users = $department->getUsers();

        return $this->render('TaskeetMainBundle:UserList:users.html.twig', array(
            'assignedTo' => $users
        ));
    }

    public function usersByDepartamentAction()
    {
        $department_id = $this->getRequest()->request->get('department_id');

        $em = $this->getDoctrine()->getManager();

        $department = $em->getRepository('TaskeetMainBundle:Department')->find($department_id);

        $users = $department->getUsers();
        $userArray = array();
        $arrayresultante = array();
        foreach ($users as $user) {
            $userArray['value'] = $user->getId();
            if ($user->getFirstName())
                $userArray['nombre'] = $user->getFullName();
            else
                $userArray['nombre'] = $user->getUserName();
            $arrayresultante[] = $userArray;
        }
        return new Response(json_encode($arrayresultante));
    }

    public function departmentsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $departments = $em->getRepository('TaskeetMainBundle:Department')->findAll();

        return $this->render('TaskeetMainBundle:DepartmentList:departments.html.twig', array(
            'assignedTo' => $departments,
        ));
    }
}
