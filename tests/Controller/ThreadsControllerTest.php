<?php

namespace App\Tests\Controller;


use App\Entity\Reply;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ThreadsControllerTest extends WebTestCase
{
    private $client;

    protected function setUp()
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    /** @test */
    public function testAUserCanOpenTheListPage()
    {
        $this->client->request('GET', '/threads');
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    /** @test */
    public function testAUserCanOpenTheShowPage()
    {
        $this->client->request('GET', '/threads/veniam-quas-ipsum-in-nostrum');
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }
}