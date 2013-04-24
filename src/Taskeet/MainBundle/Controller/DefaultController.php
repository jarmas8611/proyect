<?php

namespace Taskeet\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TaskeetMainBundle:Default:index.html.twig', array('name' => $name));
    }
}
