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

        if (isset($scopes['group_1']) && $scopes['group_1'] == 'Proyectos del departamento') {
//            $queryFilter->addCollectionFilter("departments", $this->getUser()->getDepartment());
            $query
                ->leftJoin('q.departments', 'd')
                ->where('d = :dep')
                ->orWhere('d.parent = :dep')
                ->setParameter('dep', $this->getUser()->getDepartment());
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

        return $this->render('TaskeetMainBundle:ProjectList:miniList.html.twig', $this->getAdditionalRenderParameters() + array(
            'Projects' => $this->getPager(),
        ));

    }

//    public function getQuery()
//    {
//        $departments = $this->getUser()->getDepartments();
//        foreach ($departments as $value)
//        {
//            $filters['departments'] = $this->getDoctrine()->getRepository('TaskeetMainBundle:Project')->findByDepartments($value->getId());
//        }
//
//    }
}
