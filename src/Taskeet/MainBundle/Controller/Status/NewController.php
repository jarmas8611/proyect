<?php

namespace Taskeet\MainBundle\Controller\Status;

use Admingenerated\TaskeetMainBundle\BaseStatusController\NewController as BaseNewController;

class NewController extends BaseNewController
{

	/**
     * This method is here to make your life better, so overwrite  it
     *
     * @param \Symfony\Component\Form\Form $form the valid form
     * @param \Taskeet\MainBundle\Entity\Status $Status your \Taskeet\MainBundle\Entity\Status object
     */
    public function preSave(\Symfony\Component\Form\Form $form, \Taskeet\MainBundle\Entity\Status $Status)
    {
    	if($Status->isPrimary() == true){    		
    		$em = $this->getDoctrine()->getEntityManager();
	    	$status = $em->getRepository('TaskeetMainBundle:Status')->findByPrimary($Status->isPrimary());
	    	if(count($status) > 0){
	    		$status[0]->setPrimary(false);
		    	$em->persist($status[0]);
				$em->flush();	
	    	}   	
	    	
    	}  
    }
}
