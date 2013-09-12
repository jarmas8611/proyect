<?php

namespace Taskeet\MainBundle\Controller\Priority;

use Admingenerated\TaskeetMainBundle\BasePriorityController\DeleteController as BaseDeleteController;

class DeleteController extends BaseDeleteController
{
	/**
    * This method is here to make your life better, so overwrite it
    *
    * @param \Taskeet\MainBundle\Entity\Priority $Priority your \Taskeet\MainBundle\Entity\Priority object
    */
    public function postRemove(\Taskeet\MainBundle\Entity\Priority $Priority)
    {
    	if($Priority->isPrimary() == true){  	
    		$em = $this->getDoctrine()->getEntityManager();
	    	$priority = $em->getRepository('TaskeetMainBundle:Priority')->findAll();	    
	    	if(count($priority) > 0){	
		    	$priority[0]->setPrimary(true);
		    	$em->persist($priority[0]);
				$em->flush();	    
			}	
    	}    	
    }
}
