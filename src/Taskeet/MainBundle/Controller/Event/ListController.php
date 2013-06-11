<?php

namespace Taskeet\MainBundle\Controller\Event;

use Admingenerated\TaskeetMainBundle\BaseEventController\ListController as BaseListController;

class ListController extends BaseListController
{
    public function calendarAction()
    {
        return $this->render('TaskeetMainBundle:EventList:calendar.html.twig');
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

        return $this->render('TaskeetMainBundle:EventList:miniList.html.twig', $this->getAdditionalRenderParameters() + array(
            'Events' => $this->getPager(),
        ));

    }
}
