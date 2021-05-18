<?php

namespace App\Tests\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;

class TaskControllerTest extends AbstractControllerTest
{

    /** @var TaskRepository */
    protected $taskRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->taskRepository = self::$container->get(TaskRepository::class);
    }

    public function testList(): void
    {
        $this->client->request('GET', '/tasks');
        self::assertEquals(302, $this->client->getResponse()->getStatusCode());

        $this->loginWithAdmin();

        $crawler = $this->client->request('GET', '/tasks');
        self::assertEquals(200, $this->client->getResponse()->getStatusCode());
        self::assertStringContainsString('Créer une tâche', $crawler->filter('a.btn.btn-info')->text());
    }

    public function testCreate(): void
    {
        $this->client->request('GET', '/tasks/create');
        self::assertEquals(302, $this->client->getResponse()->getStatusCode());

        $this->loginWithAdmin();

        $crawler = $this->client->request('GET', '/tasks/create');
        self::assertEquals(200, $this->client->getResponse()->getStatusCode());
        self::assertCount(2, $crawler->filter('input'));
        self::assertEquals('Ajouter', $crawler->filter('button.btn.btn-success')->text());

        $buttonCrawlerMode = $crawler->filter('form');
        $form = $buttonCrawlerMode->form([
            'task[title]' => 'Titre de la tâche 2',
            'task[content]' => 'Description de la tâche 2'
        ]);

        $this->client->submit($form);
        self::assertEquals(302, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect();
        self::assertEquals('task_list', $this->client->getRequest()->get('_route'));
        self::assertEquals(
            'Superbe ! La tâche a été bien été ajoutée.',
            $crawler->filter('div.alert.alert-success')->text(null, true)
        );

        $task = $this->taskRepository->findOneBy(['title' => 'Titre de la tâche 2']);
        self::assertInstanceOf(Task::class, $task);
        self::assertEquals('Titre de la tâche 2', $task->getTitle());
        self::assertEquals('Description de la tâche 2', $task->getContent());
        self::assertEquals('zaams1', $task->getAuthor()->getUsername());
        self::assertEquals('hugo.platret@gmail.com', $task->getAuthor()->getEmail());
    }

    public function testEdit(): void
    {
        $task = $this->taskRepository->findOneBy(['title' => 'Titre de la tâche 2']);
        $this->client->request('GET', '/tasks/2/edit');
        self::assertEquals(302, $this->client->getResponse()->getStatusCode());

        $this->loginWithAdmin();

        $crawler = $this->client->request('GET', '/tasks/2/edit');
        self::assertEquals(200, $this->client->getResponse()->getStatusCode());
        self::assertCount(2, $crawler->filter('input'));
        self::assertEquals('Modifier', $crawler->filter('button.btn.btn-success')->text());

        $buttonCrawlerMode = $crawler->filter('form');
        $form = $buttonCrawlerMode->form([
            'task[title]' => 'Titre de la tâche1',
            'task[content]' => 'Description de la tâche1'
        ]);

        $this->client->submit($form);
        self::assertEquals(302, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect();
        self::assertEquals('task_list', $this->client->getRequest()->get('_route'));
        self::assertEquals(
            'Superbe ! Superbe ! La tâche a bien été modifiée.',
            $crawler->filter('div.alert.alert-success')->text(null, true)
        );

        $task = $this->taskRepository->findOneBy(['title' => 'Titre de la tâche1']);
        self::assertInstanceOf(Task::class, $task);
        self::assertEquals('Titre de la tâche1', $task->getTitle());
        self::assertEquals('Description de la tâche1', $task->getContent());
        self::assertEquals('zaams1', $task->getAuthor()->getUsername());
        self::assertEquals('hugo.platret@gmail.com', $task->getAuthor()->getEmail());
    }

    public function testToggle(): void
    {
        $this->client->request('GET', '/tasks/2/toggle');
        self::assertEquals(302, $this->client->getResponse()->getStatusCode());

        $this->loginWithAdmin();

        $this->client->request('GET', '/tasks/2/toggle');
        self::assertEquals(302, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect();
        self::assertEquals('task_list', $this->client->getRequest()->get('_route'));
        self::assertEquals(
            'Superbe ! La tâche Titre de la tâche1 a bien été marquée comme faite.',
            $crawler->filter('div.alert.alert-success')->text(null, true)
        );

        $task = $this->taskRepository->findOneBy(['title' => 'Titre de la tâche1']);
        self::assertInstanceOf(Task::class, $task);
        self::assertEquals(true, $task->getIsDone());
    }

    public function testDelete(): void
    {
        $this->client->request('DELETE', '/tasks/2/delete');
        self::assertEquals(302, $this->client->getResponse()->getStatusCode());

        $this->loginWithAdmin();

        $this->client->request('DELETE', '/tasks/2/delete');
        self::assertEquals(302, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect();
        self::assertEquals('task_list', $this->client->getRequest()->get('_route'));
        self::assertEquals(
            'Superbe ! La tâche a bien été supprimée.',
            $crawler->filter('div.alert.alert-success')->text(null, true)
        );

        $task = $this->taskRepository->findOneBy(['title' => 'Titre de la tâche1']);
        self::assertEmpty($task);
    }
}