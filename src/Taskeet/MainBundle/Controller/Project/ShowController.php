<?php

namespace Taskeet\MainBundle\Controller\Project;

use Admingenerated\TaskeetMainBundle\BaseProjectController\ShowController as BaseShowController;
use Ob\HighchartsBundle\Highcharts\Highchart;

class ShowController extends BaseShowController
{
    public function chartAction($pk)
    {
        $Project = $this->getObject($pk);

        $this->checkCredentials($Project);


        if (!$Project) {
            throw new NotFoundHttpException("The Taskeet\MainBundle\Entity\Project with id $pk can't be found");
        }

        $ob = new Highchart();
        $ob->chart->renderTo('linechart');
        $ob->title->text($Project->getName());
        $ob->plotOptions->pie(array(
            'allowPointSelect'  => true,
            'cursor'    => 'pointer',
            'dataLabels'    => array('enabled' => false),
            'showInLegend'  => true
        ));
        $data = array();
        foreach ($Project->getTickets() as $task)
        {
            $data[] = array($task->getStatus()->getName(), +1);
        }
//        $g = array($data);
        $ob->series(array(array('type' => 'pie','name' => 'Estado de las tareas', 'data' => $data)));

        return $this->render('TaskeetMainBundle:ProjectShow:chart.html.twig', $this->getAdditionalRenderParameters($Project) + array(
            "Project" => $Project, 'chart' => $ob
        ));
    }
}
