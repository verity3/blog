<?php

namespace NewsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Description of NewsController
 *
 * @author Rosana Pencheva <rossana.russeva@gmail.com>
 */
class NewsControllerTest extends WebTestCase
{
    
    public function testCompleteScenario()
    {
        // Create news to browse the application
        $client = static::createClient();
        // Create a new entry in the database
        $crawler = $client->request('GET', '/news');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /news");
        $crawler = $client->click($crawler->selectLink('New')->link());
        // Fill in the form and submit it
        $form = $crawler->selectButton('Save')->form(array(
            'news_form[title]'  => 'Test',
            'news_form[text]'  => 'Some text',
            'news_form[active]'  => 1,
        ));
        $client->submit($form);
        $crawler = $client->followRedirect();
        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("Test")')->count(), 'Missing element td:contains("Test")');
        
        // Delete the entity
        $client->submit($crawler->selectLink('Delete')->link());
        $crawler = $client->followRedirect();
        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Test/', $client->getResponse()->getContent());
    }
    
}