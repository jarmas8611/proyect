<?php

namespace Taskeet\MainBundle\Controller\Project;

use Admingenerated\TaskeetMainBundle\BaseProjectController\ListController as BaseListController;

class ListController extends BaseListController
{
    protected function processScopes($query)
    {
        $scopes = $this->getScopes();

        $queryFilter = $this->get('admingenerator.queryfilter.doctrine');
        $queryFilter->setQuery($query);



        if (isset($scopes['group_1']) && $scopes['group_1'] == 'Todos') {

        }

        if (isset($scopes['group_1']) && $scopes['group_1'] == 'Mis proyectos') {
            $queryFilter->addCollectionFilter("members", $this->getUser());
        }
    }
}
