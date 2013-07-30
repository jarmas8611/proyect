<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rafix
 * Date: 20/07/13
 * Time: 17:02
 * To change this template use File | Settings | File Templates.
 */

namespace Taskeet\MainBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ReminderCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('taskeet:reminder')
            ->setDescription("Envía e-mail recordando tareas para el día en curso")
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tickets = $this->getContainer()->get('doctrine')->getRepository('TaskeetMainBundle:Ticket')->findAll();

         foreach($tickets as $t)
         {
             $ahora = new \DateTime('now');
             $ahora->format('Y-m-d H:i');
             $remind = $t->getReminder();
             $remind->format('Y-m-d H:i');

             if($ahora->format('Y-m-d H:i') == $remind->format('Y-m-d H:i'))
             {
                 $user = $t->getAssignedTo();
                 $body = $this->getContainer()->get('templating')->render('TaskeetMainBundle:Default:reminder.txt.twig', array(
                     'Ticket' => $t,
                 ));

                 $message = \Swift_Message::newInstance()
                     ->setSubject("[Taskeet] Recordatorio de tarea pendiente")
                     ->setFrom('no-reply@personaltask.com')
                     ->setTo($user->getEmail())
                     ->setBody($body)
                 ;
                 $this->getContainer()->get('mailer')->send($message);
//                 $output->writeln($body);
             }

         }

    }
}