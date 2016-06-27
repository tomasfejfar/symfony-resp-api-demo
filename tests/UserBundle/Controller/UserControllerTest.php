<?php

namespace AppBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function setUp()
    {
        $this->loadFixtures([
            'AppBundle\Fixtures\LoadData',
        ]);
    }

    private function request($uri, $method, $data = null)
    {
        $headers = ['CONTENT_TYPE' => 'application/json'];
        $content = null;
        if ($data) {
            $content = json_encode($data);
        }
        $client = static::createClient();
        $client->request($method, $uri, [], [], $headers, $content);
        return $client;
    }

    public function testIndex()
    {
        $client = $this->request('GET', '/api/v1/users');

        $this->assertContains('Hello World', $client->getResponse()->getContent());
    }
}
