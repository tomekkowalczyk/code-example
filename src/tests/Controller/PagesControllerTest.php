<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PagesControllerTest extends WebTestCase
{

    /**
     * @dataProvider getPublicUrls
     */
    public function testPublicUrls(string $url)
    {
        $client = static::createClient();
        $crawler = $client->request('GET', $url);
        $this->assertSame(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
        $this->assertCount(1, $crawler->filter('h1'));
    }

    public function getPublicUrls()
    {
        yield ['/'];
        yield ['/blog'];
        yield ['/nauka-plywania-dla-dzieci-krakow'];
        yield ['/nauka-plywania-dla-doroslych-krakow'];
        yield ['/obozy-kolonie-plywackie'];
        yield ['/login'];
    }
}
