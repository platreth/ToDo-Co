<?php

namespace App\Tests\Controller;

class SecurityControllerTest extends AbstractControllerTest
{

    public function testLoginWithValidData(): void
    {
        $crawler = $this->client->request('GET', '/login');
        self::assertEquals(200, $this->client->getResponse()->getStatusCode());
        self::assertCount(2, $crawler->filter('input'));
        self::assertStringContainsString('Se connecter', $crawler->filter('button.btn-success')->text());

        $this->loginWithAdmin();

        self::assertEquals(302, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect();

        self::assertStringContainsString('Créer une nouvelle tâche', $crawler->filter('a.btn.btn-success')->text());
        self::assertStringContainsString(
            'Consulter la liste des tâches à faire',
            $crawler->filter('a.btn.btn-info')->text()
        );
        self::assertStringContainsString(
            "Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !",
            $crawler->filter('h1')->text()
        );
    }

    public function testLoginWithInvalidData(): void
    {
        $crawler = $this->client->request('GET', '/login');
        self::assertEquals(200, $this->client->getResponse()->getStatusCode());

        $buttonCrawlerMode = $crawler->filter('form');
        $form = $buttonCrawlerMode->form([
            '_username' => 'test1',
            '_password' => 'test'
        ]);

        $this->client->submit($form);

        self::assertEquals(302, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect();
        self::assertEquals(
            'Invalid credentials.',
            $crawler->filter('div.alert-danger')->text(null, true)
        );
    }

    public function testLoginWithInvalidPassword(): void
    {
        $crawler = $this->client->request('GET', '/login');
        self::assertEquals(200, $this->client->getResponse()->getStatusCode());

        $buttonCrawlerMode = $crawler->filter('form');
        $form = $buttonCrawlerMode->form([
            '_username' => 'admin',
            '_password' => 'test'
        ]);

        $this->client->submit($form);

        self::assertEquals(302, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect();
        self::assertEquals(
            'Invalid credentials.',
            $crawler->filter('div.alert.alert-danger')->text(null, true)
        );
    }
}