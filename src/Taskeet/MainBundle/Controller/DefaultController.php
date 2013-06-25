<?php

namespace Taskeet\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ob\HighchartsBundle\Highcharts\Highchart;

class DefaultController extends Controller
{
    public function welcomeAction()
    {
        $Events = $this->getDoctrine()->getRepository('TaskeetMainBundle:Event')->findByOwner($this->getUser());

        return $this->render('TaskeetMainBundle:Dashboard:welcome.html.twig',
                                array(
                                    'User' => $this->getUser(),
                                    'events' => $Events
                                ));
    }

    public function usersAction()
    {
        $project_id = $this->getRequest()->request->get('project_id');

        $em = $this->getDoctrine()->getManager();

        $project = $em->getRepository('TaskeetMainBundle:Project')->find($project_id);

        $users = $project->getMembers();

        return $this->render('TaskeetMainBundle:UserList:users.html.twig', array(
            'assignedTo' => $users
        ));
    }
}
