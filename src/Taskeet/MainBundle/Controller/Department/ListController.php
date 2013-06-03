<?php

namespace Taskeet\MainBundle\Controller\Department;

use Admingenerated\TaskeetMainBundle\BaseDepartmentController\ListController as BaseListController;

class ListController extends BaseListController
{
    protected function processScopes($query)
    {
        $scopes = $this->getScopes();

        $queryFilter = $this->get('admingenerator.queryfilter.doctrine');
        $queryFilter->setQuery($query);



        if (isset($scopes['group_1']) && $scopes['group_1'] == 'Todos') {

        }

        if (isset($scopes['group_1']) && $scopes['group_1'] == 'Mis departamentos') {
            $queryFilter->addDefaultFilter("owner", $this->getUser());
        }
    }

}
