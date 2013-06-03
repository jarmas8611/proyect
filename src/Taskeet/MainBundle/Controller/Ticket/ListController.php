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
    }
}
