<?php

namespace Taskeet\MainBundle\Controller\Project;

use Admingenerated\TaskeetMainBundle\BaseProjectController\ShowController as BaseShowController;
use Ob\HighchartsBundle\Highcharts\Highchart;

class ShowController extends BaseShowController
{
    public function indexAction($pk)
    {
        $Project = $this->getObject($pk);

        $this->checkCredentials($Project);


        if (!$Project) {
            throw new NotFoundHttpException("The Taskeet\MainBundle\Entity\Project with id $pk can't be found");
        }

        return $this->render('TaskeetMainBundle:ProjectShow:index.html.twig', $this->getAdditionalRenderParameters($Project) + array(
            "Project" => $Project
        ));
    }

    public function chartAction($pk)
    {
        $Project = $this->getObject($pk);

        $this->checkCredentials($Project);


        if (!$Project) {
            throw new NotFoundHttpException("The Taskeet\MainBundle\Entity\Project with id $pk can't be found");
        }

        $ob = new Highchart();
        $ob->chart->renderTo($Project->getName());
        $ob->title->text($Project->getName());
        $ob->plotOptions->pie(array(
            'allowPointSelect'  => true,
            'cursor'    => 'pointer',
            'dataLabels'    => array('enabled' => false),
            'showInLegend'  => true
        ));
        $data = array();
        $datag = array();
        foreach ($Project->getTickets() as $task)
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

        return $this->render('TaskeetMainBundle:ProjectShow:chart.html.twig', $this->getAdditionalRenderParameters($Project) + array(
            "Project" => $Project, 'chart' => $ob
        ));
    }
}
