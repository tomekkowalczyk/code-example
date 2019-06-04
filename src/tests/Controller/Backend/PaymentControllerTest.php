<?php

namespace App\Tests\Controller\Backend;

use App\Entity\Payment;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PaymentControllerTest.
 */
class PaymentControllerTest extends WebTestCase
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
        yield ['GET', '/panel/platnosci'];
        yield ['GET', '/panel/platnosci/platnosc'];
    }

    public function testAdminPaymentList()
    {
        $crawler = $this->client->request('GET', '/panel/platnosci');
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertGreaterThanOrEqual(
            4,
            $crawler->filter('td')->count(),
            'The backend payment list displays all the available payments.'
        );
    }

    public function testAdminCreateNewPayment()
    {
        $name = 'wpłata za semest '.mt_rand();


        $crawler = $this->client->request('GET', '/panel/platnosci/platnosc');
        $form = $crawler->selectButton('Zapisz')->form([
            'payment[name]' => $name,
            'payment[price]' => 25,
            'payment[createDate]' => $startDate = '2019-01-01 00:00',

        ]);
        $form['payment[student]']->select(513532);


        $this->client->submit($form);
        $this->assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
        $payment = $this->client->getContainer()->get('doctrine')->getRepository(Payment::class)->findOneBy([
            'name' => $name,
        ]);
        $this->assertNotNull($payment);
        $this->assertSame($name, $payment->getName());
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
