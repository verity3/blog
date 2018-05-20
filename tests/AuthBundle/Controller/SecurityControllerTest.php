<?php

namespace AuthBundle\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SecurityControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testSecuredHello()
    {
        $this->logIn();
        $crawler = $this->client->request('GET', '/news');

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertSame('Your news', $crawler->filter('h3')->text());
    }

    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        // the firewall context defaults to the firewall name
        $firewallContext = 'main';

        $token = new UsernamePasswordToken('admin', null, $firewallContext, array('ROLE_USER'));
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
    
     public function testUserLogin() {

   $client = static::createClient();
   $crawler = $client->request('GET', '/login');

   $form = $crawler->selectButton('_submit')->form(array(
     'login[_username]'  => 'admin',
     'login[_password]'  => 'root',
   ));

   $client->submit($form);
   $crawler = $client->followRedirect('/news'); // "/" page

   // if credentials were correct, you should be logged in and ready to test your app
  }
}