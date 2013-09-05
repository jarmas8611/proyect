<?php

namespace Taskeet\MainBundle\Controller\Ticket;

use Admingenerated\TaskeetMainBundle\BaseTicketController\ListController as BaseListController;

class ListController extends BaseListController
{
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

        if (isset($scopes['group_1']) && $scopes['group_1'] == 'Finalizadas') {
            $queryFilter->addDefaultFilter("done", true);
        }
    }

    public function miniListAction()
    {
        if ($this->get('request')->query->get('page'))
        {
            $this->setPage($this->get('request')->query->get('page'));
        }

        if ($this->get('request')->query->get('sort'))
        {
            $this->setSort($this->get('request')->query->get('sort'), $this->get('request')->query->get('order_by','ASC'));
        }

//        $form = $this->getFilterForm();

        return $this->render('TaskeetMainBundle:TicketList:miniList.html.twig', $this->getAdditionalRenderParameters() + array(
            'Tickets' => $this->getPager(),
        ));

    }
}
