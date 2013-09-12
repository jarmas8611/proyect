<?php

namespace Taskeet\MainBundle\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Taskeet\MainBundle\Controller\Ticket\ListController as Controller;
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

    public function indexAction()
    {
        $comments = $this->getDoctrine()->getRepository('TaskeetMainBundle:Comment')->createQueryBuilder('c')
            ->leftJoin('c.thread', 't')
//            ->leftJoin('t.assignedTo', 'u1')
            ->where('t.createdBy = ?1')
            ->orWhere('t.assignedTo = ?2')
            ->orderBy('c.createdAt', 'DESC')
            ->setParameters(array(1 => $this->getUser()->getUsername(), 2 => $this->getUser()))
            ->setMaxResults( 3 )
            ->getQuery()
            ->getResult();
//        $comments =  $em->getRepository('TaskeetMainBundle:Comment')->findByUser($this->getUser());

        if ($this->get('request')->query->get('page'))
        {
            $this->setPage($this->get('request')->query->get('page'));
        }

        if ($this->get('request')->query->get('sort'))
        {
            $this->setSort($this->get('request')->query->get('sort'), $this->get('request')->query->get('order_by','ASC'));
        }

        $form = $this->getFilterForm();

        return $this->render('TaskeetMainBundle:Dashboard:ticketList.html.twig', $this->getAdditionalRenderParameters() + array(
            'Tickets' => $this->getPager(),
            'form'                      => $form->createView(),
            'sortColumn'                => $this->getSortColumn(),
            'sortOrder'                 => $this->getSortOrder(),
            'scopes'                    => $this->getScopes(),
            'comments'                  => $comments,
        ));
    }

    protected function processScopes($query)
    {
        $scopes = $this->getScopes();

        $queryFilter = $this->get('admingenerator.queryfilter.doctrine');
        $queryFilter->setQuery($query);



        if (isset($scopes['group_1']) && $scopes['group_1'] == 'Todas') {

        }

        if (isset($scopes['group_1']) && $scopes['group_1'] == 'Mis tareas') {
            $queryFilter->addDefaultFilter("assignedTo", $this->getUser());
        }

        if (isset($scopes['group_1']) && $scopes['group_1'] == 'Tareas del departamento') {
            $query
                ->leftJoin('q.assignedTo', 'u')
                ->leftJoin('u.department', 'd')
                ->where('u.department = :dep')
                ->orWhere('d.parent = :dep')
                ->setParameter('dep', $this->getUser()->getDepartment());
        }

        if (isset($scopes['group_1']) && $scopes['group_1'] == 'Para hoy') {
            $query
                ->where('startDate >= ?1')
                ->orWhere('dueDate = ?1')
                ->andWhere('assignedTo = ?2')
                ->setParameters(array(1 => new \DateTime('today'), 2 => $this->getUser()));
        }

        if (isset($scopes['group_1']) && $scopes['group_1'] == 'Finalizadas') {
            $queryFilter->addDefaultFilter("done", true);
        }
    }

    public function priorityStatusDefaultAction(){
        $em = $this->getDoctrine()->getManager();

        $priority = $em->getRepository('TaskeetMainBundle:Priority')->findByPrimary(true);
        $status = $em->getRepository('TaskeetMainBundle:Status')->findByPrimary(true);
        
        //var_dump($priority);
        $datos['prioridad'] = $priority[0]->getId();   
        $datos['estado'] = $status[0]->getId();
        return new Response(json_encode($datos));    
    }
}
