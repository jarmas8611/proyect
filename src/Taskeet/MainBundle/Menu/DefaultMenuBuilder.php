<?php

namespace Taskeet\MainBundle\Menu;

use Symfony\Component\HttpFoundation\Request;
use Admingenerator\GeneratorBundle\Menu\AdmingeneratorMenuBuilder;

class DefaultMenuBuilder extends AdmingeneratorMenuBuilder
{
    /**
     * @param Request $request
     * @param Router  $router
     */
    public function createAdminMenu(Request $request)
    {
        $menu = parent::createAdminMenu($request);

        /**
         * Translation domain is passed down to child elements
         * in addNavLinkURI, addNavLinkRoute, addDropdownMenu methods.
         */
        $menu->setExtra('translation_domain', 'Admingenerator');

        $menu->addChild('Departamentos', array('route' => 'Taskeet_MainBundle_Department_list'));


        $help = $this->addDropdownMenu($menu, 'Proyectos');

        $this->addNavLinkRoute($help, 'Proyectos', 'Taskeet_MainBundle_Project_list');
        $this->addNavLinkRoute($help, 'Categorias', 'Taskeet_MainBundle_Category_list');
        $this->addNavLinkRoute($help, 'Prioridades', 'Taskeet_MainBundle_Priority_list');
        $this->addNavLinkRoute($help, 'Tareas', 'Taskeet_MainBundle_Ticket_list');
//        $this->addNavLinkRoute($help, 'Configure php class to use', 'https://github.com/symfony2admingenerator/AdmingeneratorGeneratorBundle/blob/master/Resources/doc/change-the-menu-class.markdown');

        $menu->addChild('Agenda', array('route' => 'Taskeet_MainBundle_Event_list'));
        $menu->addChild('Usuarios', array('route' => 'Taskeet_MainBundle_User_list'));

        return $menu;
    }
}
