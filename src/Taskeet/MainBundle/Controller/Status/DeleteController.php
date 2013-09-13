<?php

namespace Taskeet\MainBundle\Controller\Status;

use Admingenerated\TaskeetMainBundle\BaseStatusController\DeleteController as BaseDeleteController;

class DeleteController extends BaseDeleteController
{
	/**
    * This method is here to make your life better, so overwrite it
    *
    * @param \Taskeet\MainBundle\Entity\Status $Status your \Taskeet\MainBundle\Entity\Status object
    */
    public function preRemove(\Taskeet\MainBundle\Entity\Status $Status)
    {
    	if($Status->isPrimary() == true){  	
    		$em = $this->getDoctrine()->getEntityManager();
	    	$status = $em->getRepository('TaskeetMainBundle:Status')->findAll();	    
	    	if(count($status) > 0){	
		    	$status[0]->setPrimary(true);
		    	$em->persist($status[0]);
				$em->flush();	    
			}	
    	}   
    }
}
