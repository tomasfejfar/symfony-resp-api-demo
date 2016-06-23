<?php

namespace UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function setUp()
    {
    }
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/v1/users');

        $this->assertContains('Hello World', $client->getResponse()->getContent());
    }
}
