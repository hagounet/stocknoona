<?php
// src/Noona/appBundle/Command/RappelCommand.php
namespace Noona\AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RappelCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('rappel:send')
            ->setDescription('Envoyer un rappel')
            ->addArgument('userName', InputArgument::OPTIONAL, 'A qui voulez vous envoyer le message?')
            //->addOption('yell', null, InputOption::VALUE_NONE, 'Si définie, la tâche criera en majuscules')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userName = $input->getArgument('userName');
        if (!$userName) {
            $userName = 'amal';
        } 
        $em = $this
                    ->getContainer()
                    ->get('doctrine')
                    ->getManager()
                            ;

        $userRepo = $em->getRepository('NoonaUserBundle:User');
        $user = $userRepo -> findOneByUsername($userName);

        if(!$user){
            $output->writeln('aucun utilisateur de ce nom trouvé');
            return;
        }

        

        $body = 'Hello '.$user->getUsername().', ça fait un moment que tu n\'as pas mis les stock à jour. Au boulot stp, merci.';
         $message = \Swift_Message::newInstance()
        ->setSubject('Rappel de stock')
        ->setFrom('smoriggi@newebregie.fr')
        ->setTo($user->getEmail())
        ->setBody($body)
    ;

        $diff =   (date_timestamp_get(new \DateTime('now')) -  date_timestamp_get($user->getLastlogin()) ) /60/60/24; //nombre de jours

        $limit = 7;

        if($diff >= $limit){
            $this->getContainer()->get('mailer')->send($message);
            $output->writeln('Le mail a été envoyé');
            return;
        }
        $output->writeln('Plus que '.ceil($limit-$diff).' jour(s) avant envoi du mail');

        //if ($input->getOption('yell')) {
        //    $text = strtoupper($text);
        //}
        

        
    }
}