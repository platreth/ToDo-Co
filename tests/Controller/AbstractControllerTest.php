<?php

namespace App\Tests\Controller;

use App\DataFixtures\AppFixtures;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

abstract class AbstractControllerTest extends WebTestCase
{
    // private $encoder;

    // public function __construct(UserPasswordEncoderInterface $encoder)
    // {
    //     $this->encoder = $encoder;
    // }

    protected $client;

    protected function setUp(): void
    {
        // static::$kernel = static::createKernel();
        // static::$kernel->boot();
        // $this->em = static::$kernel->getContainer()
        //     ->get('doctrine')
        //     ->getManager()
        // ;
        
        // $loader = new Loader();
        // $encoder = $this->encoder;
        // $fixtures = new AppFixtures($encoder);
        // $loader->addFixture($fixtures);
    
        // $purger = new ORMPurger($this->em);
        // $executor = new ORMExecutor($this->em, $purger);
        // $executor->execute($loader->getFixtures());
    
        parent::setUp();
        $this->client = static::createClient();
      }

    public function loginWithAdmin(): void
    {
        $crawler = $this->client->request('GET', '/login');

        $buttonCrawlerMode = $crawler->filter('form');
        $form = $buttonCrawlerMode->form([
            '_username' => 'zaams1',
            '_password' => 'coucou'
        ]);

        $this->client->submit($form);
    }

    public function loginWithUser(): void
    {
        $crawler = $this->client->request('GET', '/login');

        $buttonCrawlerMode = $crawler->filter('form');
        $form = $buttonCrawlerMode->form([
            '_username' => 'zaams',
            '_password' => 'coucou'
        ]);

        $this->client->submit($form);
    }
}