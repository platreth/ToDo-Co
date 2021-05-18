<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user1 = new User;
        $user1->setEmail("hugo.platret@gmail.com");
        $password = $this->encoder->encodePassword($user1, 'coucou');
        $user1->setPassword($password);
        $user1->setUsername('zaams1');
        $user1->setRoles(["ROLE_ADMIN"]);

        $manager->persist($user1);

        $user2 = new User;
        $user2->setEmail("hugo.platret1@gmail.com");
        $password = $this->encoder->encodePassword($user1, 'coucou');
        $user2->setPassword($password);
        $user2->setUsername('zaams');

        $manager->persist($user2);

        $task = new Task;
        $task->setAuthor($user2);
        $task->setCreatedAt(new DateTime());
        $task->setTitle("Titre de la tâche");
        $task->setContent("Description de la tâche");
        $task->setIsDone(1);

        $manager->persist($task);

        $manager->flush();
    }
}
