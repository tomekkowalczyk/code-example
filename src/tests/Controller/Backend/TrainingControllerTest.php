<?php

namespace App\Tests\Controller\Backend;

use App\Entity\Training;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TrainingControllerTest.
 */
class TrainingControllerTest extends WebTestCase
{
    public $clientStudent;
    public $clientAdmin;

    public function setUp()
    {
        $this->clientAdmin = static::createClient([], [
         'PHP_AUTH_USER' => 'tomek_admin@test.pl',
         'PHP_AUTH_PW' => 'admin',
        ]);

        $this->clientStudent = static::createClient([], [
            'PHP_AUTH_USER' => 'kuba_student@test.pl',
            'PHP_AUTH_PW' => 'student',
        ]);
    }

    /**
     * @return \Generator
     */
    public function getUrlsForStudents()
    {
        yield ['GET', '/strefa-ucznia/treningi'];
    }

    /**
     * @return \Generator
     */
    public function getUrlsForAdmin()
    {
        yield ['GET', '/panel/treningi/lista'];
        yield ['GET', '/panel/treningi/trening'];
        yield ['GET', '/panel/trening/dziennik-obecnosci'];
    }

    /**
     * @dataProvider getUrlsForAdmin
     *
     * @param string $httpMethod
     * @param string $url
     */
    public function testAccessDeniedForStudents(string $httpMethod, string $url)
    {
        $this->clientStudent->request($httpMethod, $url);
        $this->assertSame(Response::HTTP_FORBIDDEN, $this->clientStudent->getResponse()->getStatusCode());
    }

    /**
     * @dataProvider getUrlsForAdmin
     *
     * @param string $httpMethod
     * @param string $url
     */
    public function testAccessForAdmin(string $httpMethod, string $url)
    {
        $this->clientAdmin->request($httpMethod, $url);
        $this->assertSame(Response::HTTP_OK, $this->clientAdmin->getResponse()->getStatusCode());
    }



    public function testAdminTrainingList()
    {
        $crawler = $this->clientAdmin->request('GET', '/panel/treningi/lista');
        $this->assertSame(Response::HTTP_OK, $this->clientAdmin->getResponse()->getStatusCode());
        $this->assertGreaterThanOrEqual(
            5,
            $crawler->filter('div > .card')->count()
        );
    }

    public function testAdminCreateNewTraining()
    {
        $students = [513532];
        $coach = 513539;
        $group = 'number_1';
        $startDate = '2019-04-02 18:00';
        $endDate = '2019-04-02 19:00';

        $crawler = $this->clientAdmin->request('GET', '/panel/treningi/trening');
        $form = $crawler->selectButton('Zapisz')->form([
            'training[startDate]' => $startDate,
            'training[endDate]' => $endDate,
        ]);
        $form['training[students]']->select($students);
        $form['training[coach]']->select($coach);
        $form['training[group]']->select($group);

        $this->clientAdmin->submit($form);
        $this->assertSame(Response::HTTP_FOUND, $this->clientAdmin->getResponse()->getStatusCode());
        $training = $this->clientAdmin->getContainer()->get('doctrine')->getRepository(Training::class)->findOneBy([
            'startDate' => new \DateTime($startDate),
        ]);
        $this->assertNotNull($training);
        $this->assertSame($coach, $training->getCoach()->getUid());
        $this->assertSame($group, $training->getGroup()->getSlug());
        $this->assertSame($startDate, $training->getStartDate()->format('Y-m-d H:i'));
        $this->assertSame($endDate, $training->getEndDate()->format('Y-m-d H:i'));
    }

    public function testAdminEditTraining()
    {
        $newTrainingStartDate = '2019-05-13 22:00';
        $crawler = $this->clientAdmin->request('GET', '/panel/treningi/trening/1503191641');
        $form = $crawler->selectButton('Zapisz')->form([
            'training[startDate]' => $newTrainingStartDate,
        ]);
        $this->clientAdmin->submit($form);
        $this->assertSame(Response::HTTP_FOUND, $this->clientAdmin->getResponse()->getStatusCode());
        $training = $this->clientAdmin->getContainer()->get('doctrine')->getRepository(Training::class)->findOneBy(['uid' => '1503191641']);
        $this->assertSame($newTrainingStartDate, $training->getStartDate()->format('Y-m-d H:i'));
    }

    public function testAdminDeleteTraining()
    {
        $crawler = $this->clientAdmin->request('GET', '/panel/treningi/trening/1503191641');
        $this->clientAdmin->click($crawler->filter('#delete-item')->link());
        $this->assertSame(Response::HTTP_FOUND, $this->clientAdmin->getResponse()->getStatusCode());
        $training = $this->clientAdmin->getContainer()->get('doctrine')->getRepository(Training::class)->findOneBy(['uid' => '1503191641']);
        $this->assertNull($training);
    }


    public function testTrainingDiary()
    {
        $this->clientAdmin->xmlHttpRequest('POST', '/panel/trening/dziennik-obecnosci', ['student' => 513532, 'training' => 1503191641]);
        $training = $this->clientAdmin->getContainer()->get('doctrine')->getRepository(Training::class)->getQueryBuilder([
            'trainingUid' => 1503191641,
            'studentUid' => 513532,
        ])->getQuery()->getOneOrNullResult();
        $this->assertNull($training);

        $this->clientAdmin->xmlHttpRequest('POST', '/panel/trening/dziennik-obecnosci', ['student' => 513532, 'training' => 1503191643]);
        $training = $this->clientAdmin->getContainer()->get('doctrine')->getRepository(Training::class)->getQueryBuilder([
            'trainingUid' => 1503191643,
            'studentUid' => 513532,
        ])->getQuery()->getOneOrNullResult();
        $this->assertNotNull($training);
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
