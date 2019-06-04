<?php

namespace App\Tests\Controller\Backend;

use App\Entity\Group;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class GroupControllerTest.
 */
class GroupControllerTest extends WebTestCase
{
    public $client;

    public function setUp()
    {
        $this->client = static::createClient([], [
         'PHP_AUTH_USER' => 'tomek_admin@test.pl',
         'PHP_AUTH_PW' => 'admin',
        ]);
    }

    /**
     * @dataProvider getUrlsForRegularUsers
     *
     * @param string $httpMethod
     * @param string $url
     */
    public function testAccessDeniedForRegularUsers(string $httpMethod, string $url)
    {
        $client_student = static::createClient([], [
            'PHP_AUTH_USER' => 'kuba_student@test.pl',
            'PHP_AUTH_PW' => 'student',
        ]);
        $client_student->request($httpMethod, $url);
        $this->assertSame(Response::HTTP_FORBIDDEN, $client_student->getResponse()->getStatusCode());
    }

    /**
     * @return \Generator
     */
    public function getUrlsForRegularUsers()
    {
        yield ['GET', 'panel/grupy'];
        yield ['GET', 'panel/grupy/grupa'];
//        yield ['GET', '/grupy/usun/number_1/UzfJ9voqXs5mkQRW7flYX1YulZdLkg6jTt3UjvGTseI'];
    }

    public function testAdminGroupList()
    {
        $crawler = $this->client->request('GET', 'panel/grupy');
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertGreaterThanOrEqual(
            5,
            $crawler->filter('div .card')->count()
        );
    }

    public function testAdminCreateNewGroup()
    {
        $groupName = 'Group testing name '.mt_rand();
        $description = $this->generateRandomString(255);
        $poolPath = 1;
        $startDate = '2019-01-01 00:00';
        $endDate = '2019-04-21 00:00';
        $price = 25;
        $minCount = 2;
        $maxCount = 5;

        $crawler = $this->client->request('GET', 'panel/grupy/grupa');
        $form = $crawler->selectButton('Zapisz')->form([
            'group[name]' => $groupName,
            'group[description]' => $description,
            'group[poolPath]' => $poolPath,
            'group[startDate]' => $startDate,
            'group[endDate]' => $endDate,
            'group[price]' => $price,
            'group[minCount]' => $minCount,
            'group[maxCount]' => $maxCount,
        ]);
        $form['group[students]']->select(513532, 513534);
        $form['group[coach]']->select(513540);
        $form['group[educationLevel]']->select('poziom_1');
        $form['group[term]']->select('semestr_1');
        $form['group[swimmingPool]']->select('osrodek-sportowo–rekreacyjny-kurdwanów-nowy');

        $this->client->submit($form);
        $this->assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
        $group = $this->client->getContainer()->get('doctrine')->getRepository(Group::class)->findOneBy([
            'name' => $groupName,
        ]);
        $this->assertNotNull($group);
        $this->assertSame($groupName, $group->getName());
        $this->assertSame($description, $group->getDescription());
        $this->assertSame($price, $group->getPrice());
        $this->assertSame($minCount, $group->getMinCount());
        $this->assertSame($maxCount, $group->getMaxCount());
    }


    public function testAdminDeleteGroup()
    {
        $crawler = $this->client->request('GET', 'panel/grupy/grupa/number_1');
        $this->client->click($crawler->filter('#delete-item')->link());
        $this->assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
        $group = $this->client->getContainer()->get('doctrine')->getRepository(Group::class)->findOneBy(['slug' => 'number_1']);
        $this->assertNull($group);
    }

    /**
     * @param int $length
     *
     * @return string
     */
    private function generateRandomString(int $length): string
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return mb_substr(str_shuffle(str_repeat($chars, ceil($length / mb_strlen($chars)))), 1, $length);
    }
}
