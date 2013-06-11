<?php

namespace Taskeet\MainBundle\Menu;

use Symfony\Component\HttpFoundation\Request;
use Admingenerator\GeneratorBundle\Menu\AdmingeneratorMenuBuilder;

class DefaultMenuBuilder extends AdmingeneratorMenuBuilder
{
    /**
     * @param Request $request
     * @param Router  $router
     *
     */
    public function createAdminMenu(Request $request)
    {
        $menu = parent::createAdminMenu($request);

        /**
         * Translation domain is passed down to child elements
         * in addNavLinkURI, addNavLinkRoute, addDropdownMenu methods.
         */
        $menu->setExtra('translation_domain', 'Admingenerator');

        if($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            if($this->container->get('security.context')->isGranted('ROLE_JEFE_DPTO'))
            {
                $users = $this->addDropdownMenu($menu, 'Usuarios');

                $this->addNavLinkRoute($users, 'Grupos', 'Taskeet_MainBundle_Group_list');
                $this->addNavLinkRoute($users, 'Usuarios', 'Taskeet_MainBundle_User_list');

                $menu->addChild('Departamentos', array('route' => 'Taskeet_MainBundle_Department_list'));
            }

            $projects = $this->addDropdownMenu($menu, 'Proyectos');

            if($this->container->get('security.context')->isGranted('ROLE_JEFE_DPTO'))
            {
                $this->addNavLinkRoute($projects, 'Categorías', 'Taskeet_MainBundle_Category_list');
                $this->addNavLinkRoute($projects, 'Prioridades', 'Taskeet_MainBundle_Priority_list');
                $this->addNavLinkRoute($projects, 'Estados', 'Taskeet_MainBundle_Status_list');
            }

            $this->addNavLinkRoute($projects, 'Proyectos', 'Taskeet_MainBundle_Project_list');
            $this->addNavLinkRoute($projects, 'Tareas', 'Taskeet_MainBundle_Ticket_list');

            $events = $this->addDropdownMenu($menu, 'Agenda');

            $this->addNavLinkRoute($events, 'Calendario', 'taskeet_event_calendar');
            $this->addNavLinkRoute($events, 'Eventos', 'Taskeet_MainBundle_Event_list');

            if($this->container->get('security.context')->isGranted('ROLE_ADMIN'))
            {
                $this->addNavLinkRoute($events, 'Categorías', 'Taskeet_MainBundle_EventCategory_list');
            }

        }

        $menu->setChildrenAttribute('class', 'nav pull-right');

        return $menu;
    }
}
