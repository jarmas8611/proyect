<?php

namespace Taskeet\MainBundle\Controller\User;

use Admingenerated\TaskeetMainBundle\BaseUserController\ShowController as BaseShowController;
use Ob\HighchartsBundle\Highcharts\Highchart;

class ShowController extends BaseShowController
{
	public function chartAction()
    {
        $User = $this->getUser();

        $this->checkCredentials($User);


        if (!$User) {
            throw new NotFoundHttpException("The Taskeet\MainBundle\Entity\User with id $pk can't be found");
        }

        $ob = new Highchart();
        $ob->chart->renderTo($User->getId());
        $ob->title->text($User->getUsername());
        $ob->plotOptions->pie(array(
            'allowPointSelect'  => true,
            'cursor'    => 'pointer',
            'dataLabels'    => array('enabled' => false),
            'showInLegend'  => true
        ));
        $data = array();
        $datag = array();
        foreach ($User->getTasks() as $task)
        {
            if(array_key_exists($task->getStatus()->getName(), $data))
            {
                $data[$task->getStatus()->getName()] = $data[$task->getStatus()->getName()] + 1;
            }
            else
            {
                $data[$task->getStatus()->getName()] = +1;
            }

        }

        foreach ($data as $key => $value)
        {
            $datag[] = array($key, $value);
        }

        $ob->series(array(array('type' => 'pie','name' => 'Estado de las tareas', 'data' => $datag)));

        return $this->render('TaskeetMainBundle:UserShow:chart.html.twig', $this->getAdditionalRenderParameters($User) + array(
            "User" => $User, 'chart' => $ob
        ));
    }
}
