<?php

namespace Taskeet\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function welcomeAction()
    {
        return $this->render('TaskeetMainBundle:Dashboard:welcome.html.twig',
                                array('User' => $this->getUser()));
    }
}
