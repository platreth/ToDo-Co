<?php

namespace App\Command;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AnonymousUserCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:ano-user';

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        parent::__construct();
    }
    

    protected function configure()
    {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Attach anonymous user to task that doesnt have a user')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('Pour les tâches déjà créées, il faut qu’elles soient rattachées à un utilisateur “anonyme”.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        
        $task = $this->entityManager->getRepository(Task::class)->findBy(array("author" => null)); 

        $user = $this->entityManager->getRepository(User::class)->findOneBy(array("username" => "test")); 


        foreach ($task as $key) {
            $key->setAuthor($user);
            $this->entityManager->persist($key);
            $this->entityManager->flush();
            $output->write('Task id ' . $key->getId() . ' update');
        }
        
        return Command::SUCCESS;

    }
}