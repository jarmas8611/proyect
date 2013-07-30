<?php

namespace Taskeet\MainBundle\Controller\Event;

use Admingenerated\TaskeetMainBundle\BaseEventController\EditController as BaseEditController;
use DateTime;
use DateInterval;

class EditController extends BaseEditController
{
	/**
     * This method is here to make your life better, so overwrite  it
     *
     * @param \Symfony\Component\Form\Form $form the valid form
     * @param \Taskeet\MainBundle\Entity\Event $Event your \Taskeet\MainBundle\Entity\Event object
     */
    public function preSave(\Symfony\Component\Form\Form $form, \Taskeet\MainBundle\Entity\Event $Event)
    {

        if(!$form->get('reminder')->getData() instanceof DateTime && $form->get('reminder')->getData())
        {
            $date = clone $form->get('startDate')->getData();
            $date->sub(new DateInterval($form->get('reminder')->getData()));

            $Event->setReminder($date);
        } 
    }
}
