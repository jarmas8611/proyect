<?php

namespace Taskeet\MainBundle\Controller\Event;

use Admingenerated\TaskeetMainBundle\BaseEventController\ListController as BaseListController;

class ListController extends BaseListController
{
    public function calendarAction()
    {
        return $this->render('TaskeetMainBundle:EventList:calendar.html.twig');
    }
}
