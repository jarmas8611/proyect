<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rafix
 * Date: 13/06/13
 * Time: 16:01
 * To change this template use File | Settings | File Templates.
 */

namespace Taskeet\MainBundle\EventListener;

use ADesigns\CalendarBundle\Event\CalendarEvent;
use ADesigns\CalendarBundle\Entity\EventEntity;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;

class CalendarEventListener
{
    private $entityManager;
    private $sc;

    public function __construct(EntityManager $entityManager,SecurityContext $sc)
    {
        $this->entityManager = $entityManager;
        $this->sc = $sc;

    }

    public function loadEvents(CalendarEvent $calendarEvent)
    {
        $sc = $this->sc;

        $startDate = $calendarEvent->getStartDatetime();
        $endDate = $calendarEvent->getEndDatetime();

        // load events using your custom logic here,
        // for instance, retrieving events from a repository

        $companyEvents = $this->entityManager->getRepository('TaskeetMainBundle:Event')
            ->createQueryBuilder('company_events')
            ->where('company_events.startDate BETWEEN :startDate and :endDate')
            ->andWhere('company_events.owner = :owner ')
            ->setParameter(':startDate', $startDate->format('Y-m-d H:i:s'))
            ->setParameter(':endDate', $endDate->format('Y-m-d H:i:s'))
            ->setParameter(':owner',$sc->getToken()->getUser()->getId())
            ->getQuery()->getResult();


        foreach ($companyEvents as $companyEvent) {

            // create an event with a start/end time, or an all day event
            //if ($companyEvent->getAllDayEvent() === false) {
            $eventEntity = new EventEntity($companyEvent->getTitle(), $companyEvent->getStartDate(), $companyEvent->getDueDate());
            //} else {
            //  $eventEntity = new EventEntity($companyEvent->getTitle(), $companyEvent->getStartDatetime(), null, true);
            // }

            //optional calendar event settings
            if ($companyEvent->getStartDate() == $companyEvent->getDueDate())
                $eventEntity->setAllDay(true); // default is false, set to true if this is an all day event
            else
                $eventEntity->setAllDay(false);

            if ($companyEvent->getType()->getName() == "categoria 1") {
                $eventEntity->setBgColor('#FF0000'); //set the background color of the event's label
                $eventEntity->setFgColor('#FFFFFF'); //set the foreground color of the event's label
            } else {
                $eventEntity->setBgColor('#000000'); //set the background color of the event's label
                $eventEntity->setFgColor('#FFFFFF'); //set the foreground color of the event's label
            }

            $eventEntity->setUrl($companyEvent->getid() . '/edit'); // url to send user to when event label is clicked
            $eventEntity->setCssClass('my-custom-class'); // a custom class you may want to apply to event labels

            //finally, add the event to the CalendarEvent for displaying on the calendar
            $calendarEvent->addEvent($eventEntity);
        }
    }
}