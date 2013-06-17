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
        $Events = $this->getDoctrine()->getRepository('TaskeetMainBundle:Event')->findByOwner($this->getUser());

        return $this->render('TaskeetMainBundle:EventList:miniList.html.twig', $this->getAdditionalRenderParameters() + array(
            'Events' => $Events,
        ));

    }

    protected function buildQuery()
    {
        return $this->getDoctrine()
            ->getManager()
            ->getRepository('Taskeet\MainBundle\Entity\Event')
            ->createQueryBuilder('q')
            ->andWhere('q.owner = :user')
            ->setParameter(':user', $this->getUser());
    }
}
