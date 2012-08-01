<?php
namespace Melody\RoadAnalyticsBundle\Command;
 
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Sensio\Bundle\GeneratorBundle\Command\Helper\DialogHelper;
 
class SecureCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('analytics:secure')
             ->setDefinition(array(
                new InputOption('login', '', InputOption::VALUE_REQUIRED, 'Votre login'),
                new InputOption('password', '', InputOption::VALUE_REQUIRED, 'Votre password')
             ))
             ->setDescription('Vous permet de configurer votre login et votre password pour la page de statistique.')
             ->setHelp('Vous permet de configurer votre login et votre password pour la page de statistique.')
        ;
    }
  
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getDialogHelper();
        $output->writeln(array('','','Configuration de votre login et password pour accéder à votre page de statistiques'));
        $login = $dialog->ask(
            $output, 
            $dialog->getQuestion('Votre login', $input->getOption('login')), 
            $input->getOption('login')
        );
        $pwd = $dialog->ask(
            $output, 
            $dialog->getQuestion('Votre password', $input->getOption('password')), 
            $input->getOption('password')
        );
        $input->setOption('login', $login);
        $input->setOption('password', $pwd);
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = 'app/config/parameters.ini';
        $paramManager = $this->getContainer()->get('melody_road_analytics.parameters_manager');
        $params = $paramManager->parseIniFile($url);
        $params['parameters']['melody_road_analytics_login'] = '"'.$input->getOption('login').'"';
        $params['parameters']['melody_road_analytics_pwd'] = '"'.\sha1($input->getOption('password')).'"';
        $paramManager->rewriteIniFile($url, $params);
        $output->writeln(array('Les paramètres de connexion ont bien été enregistrés.','',''));
    }

    protected function getDialogHelper()
    {
        $dialog = $this->getHelperSet()->get('dialog');
        if(!$dialog || get_class($dialog) !== 'Sensio\Bundle\GeneratorBundle\Command\Helper\DialogHelper'){
            $this->getHelperSet()->set($dialog = new DialogHelper());
        }
        return $dialog;
    }
}