<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PagesControllerTest.
 */
class BlogControllerTest extends WebTestCase
{
    public function testPublicBlogPost()
    {
        $client = static::createClient();
        $blogPost = $client->getContainer()->get('doctrine')->getRepository(Post::class)->findOneBy(['slug' => 'testing-post']);
        $client->request('GET', sprintf('/blog/%s', $blogPost->getSlug()));
        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
}
