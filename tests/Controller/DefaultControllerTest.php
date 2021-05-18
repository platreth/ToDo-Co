<?php

namespace App\Tests\Controller;

use App\Tests\Controller\AbstractControllerTest;

class DefaultControllerTest extends AbstractControllerTest
{

    public function testIndex(): void
    {
        $this->client->request('GET', '/');
        self::assertEquals(302, $this->client->getResponse()->getStatusCode());

        $this->loginWithAdmin();

        $crawler = $this->client->request('GET', '/');

        self::assertEquals(200, $this->client->getResponse()->getStatusCode());
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
}