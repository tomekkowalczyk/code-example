<?php

namespace App\Tests\Controller\Backend;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class StudentControllerTest.
 */
class StudentControllerTest extends WebTestCase
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
        yield ['GET', '/panel/studenci'];
        yield ['GET', '/panel/studenci/student'];
        yield ['GET', '/panel/studenci/student/513536'];
        yield ['GET', '/panel/studenci/szczegoly-studenta/513536'];
    }

    public function testAdminStudentList()
    {
        $crawler = $this->client->request('GET', '/panel/studenci');
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertGreaterThanOrEqual(
            2,
            $crawler->filter('div > .card')->count(),
            'The backend user list displays all the available users.'
        );
    }

    public function testAdminStudentDetails()
    {
        $crawler = $this->client->request('GET', '/panel/studenci/szczegoly-studenta/513536');
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function testAdminCreateNewStudent()
    {
        $name = $this->generateRandomString(10);
        $surname = $this->generateRandomString(12);
        $phone = '678 898 789';
        $email = 'testowy_email@test.pl';
        $points = 500;

        $crawler = $this->client->request('GET', '/panel/studenci/student');
        $form = $crawler->selectButton('Zapisz')->form([
            'student[name]' => $name,
            'student[surname]' => $surname,
            'student[phone]' => $phone,
            'student[email]' => $email,
            'student[points]' => $points,
        ]);
        $form['student[educationLevel]']->select('poziom_1');

        $this->client->submit($form);
        $this->assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
        $user = $this->client->getContainer()->get('doctrine')->getRepository(User::class)->findOneBy([
            'email' => $email,
        ]);
        $this->assertNotNull($user);
        $this->assertSame($name, $user->getName());
        $this->assertSame($surname, $user->getSurname());
        $this->assertSame($phone, $user->getPhone());
        $this->assertSame($email, $user->getEmail());
        $this->assertSame($points, $user->getPoints());
    }

    public function testAdminEditStudent()
    {
        $newUserName = 'Adrian';
        $crawler = $this->client->request('GET', '/panel/studenci/student/513536');
        $form = $crawler->selectButton('Zapisz')->form([
            'student[name]' => $newUserName,
        ]);
        $this->client->submit($form);
        $this->assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
        $user = $this->client->getContainer()->get('doctrine')->getRepository(User::class)->findOneBy(['uid' => '513536']);
        $this->assertSame($newUserName, $user->getName());
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
