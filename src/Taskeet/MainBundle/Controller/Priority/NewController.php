<?php

namespace Taskeet\MainBundle\Controller\Priority;

use Admingenerated\TaskeetMainBundle\BasePriorityController\NewController as BaseNewController;

class NewController extends BaseNewController
{

	/**
     * This method is here to make your life better, so overwrite  it
     *
     * @param \Symfony\Component\Form\Form $form the valid form
     * @param \Taskeet\MainBundle\Entity\Priority $Priority your \Taskeet\MainBundle\Entity\Priority object
     */
    public function preSave(\Symfony\Component\Form\Form $form, \Taskeet\MainBundle\Entity\Priority $Priority)
    {
    	if($Priority->isPrimary() == true){    		
    		$em = $this->getDoctrine()->getEntityManager();
	    	$priority = $em->getRepository('TaskeetMainBundle:Priority')->findByPrimary($Priority->isPrimary());
	    	if(count($priority) > 0){
	    		$priority[0]->setPrimary(false);
		    	$em->persist($priority[0]);
				$em->flush();	
	    	}   	
	    	
    	}    	
    }
}
