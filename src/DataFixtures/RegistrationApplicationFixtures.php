<?php

namespace App\DataFixtures;

use App\Entity\RegistrationApplication;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class ApplicationFixtures.
 */
class RegistrationApplicationFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $applicationList = [
            [
                'uid' => 123451,
                'name' => 'Adrian',
                'surname' => 'stonoga',
                'birthday' => '2007-11-20',
                'email' => 'test2@test.pl',
                'phone' => '666222666',
                'comment' => 'Lorem ipsum dolor Lorem ipsum dolor Lorem ipsum dolor.',
                'description' => 'Dolor Lorem ipsum dolor Lorem ipsum dolor.',
                'createDate' => '2019-02-01 20:18:12',
                'swimmingPool' => 'osrodek-sportowo–rekreacyjny-kurdwanów-nowy',
                'educationLevel' => 'poziom_1',
                'unread' => true,
                'registered' => true,
                'status' => 'call',
            ],
            [
                'uid' => 123452,
                'name' => 'Kuba',
                'surname' => 'Marmol',
                'birthday' => '2008-06-05',
                'email' => 'test6@test.pl',
                'phone' => '896789569',
                'comment' => 'Lorem ipsum dolor Lorem ipsum dolor.',
                'description' => 'Dolor Lorem ipsum dolor Lorem ipsum dolor.',
                'createDate' => '2019-01-01 21:18:19',
                'swimmingPool' => 'osrodek-sportowo–rekreacyjny-kurdwanów-nowy',
                'educationLevel' => 'poziom_1',
                'unread' => true,
                'registered' => false,
                'status' => 'no_contact',
            ],
            [
                'uid' => 123453,
                'name' => 'Łukasz',
                'surname' => 'Psikuta',
                'birthday' => '2001-01-25',
                'email' => 'test0@test.pl',
                'phone' => '555222666',
                'comment' => 'Olor Lorem ipsum dolor ipsum dolor ipsum dolor.',
                'description' => '',
                'createDate' => '2019-03-20 11:12:22',
                'swimmingPool' => 'osrodek-sportowo–rekreacyjny-kurdwanów-nowy',
                'educationLevel' => 'poziom_2',
                'unread' => false,
                'registered' => false,
                'status' => 'group',
            ],
            [
                'uid' => 123454,
                'name' => 'Miarian',
                'surname' => 'Kononowicz',
                'birthday' => '2004-03-26',
                'email' => 'test9@test.pl',
                'phone' => '112569789',
                'comment' => 'Lorem ipsum dolor Lorem ipsum dolor Lorem ipsum dolor.',
                'description' => '',
                'createDate' => '2019-01-29 10:23:12',
                'swimmingPool' => 'osrodek-sportowo–rekreacyjny-kurdwanów-nowy',
                'educationLevel' => 'poziom_3',
                'unread' => false,
                'registered' => false,
                'status' => 'call',
            ],
            [
                'uid' => 123455,
                'name' => 'Miarian',
                'surname' => 'Protasiewicz',
                'birthday' => '1996-03-26',
                'email' => 'test10@test.pl',
                'phone' => '666 258 036',
                'comment' => 'Lorem ipsum dolor Lorem ipsum dolor Lorem ipsum dolor.',
                'description' => '',
                'createDate' => '2019-01-23 11:11:12',
                'swimmingPool' => 'osrodek-sportowo–rekreacyjny-kurdwanów-nowy',
                'educationLevel' => 'poziom_3',
                'unread' => false,
                'registered' => false,
                'status' => 'call',
            ],
        ];

        foreach ($applicationList as $idx => $details) {
            $application = new RegistrationApplication();

            $application->setName($details['name'])
                    ->setUid($details['uid'])
                    ->setSurname($details['surname'])
                    ->setBirthday(new \DateTime($details['birthday']))
                    ->setEmail($details['email'])
                    ->setPhone($details['phone'])
                    ->setComment($details['comment'])
                    ->setDescription($details['description'])
                    ->setCreateDate(new \DateTime($details['createDate']))
                    ->setUnread($details['unread'])
                    ->setRegistered($details['registered'])
                ;

            $application->setSwimmingPool($this->getReference('swimming_pool_'.$details['swimmingPool']));
            $application->setEducationLevel($this->getReference('education_level_'.$details['educationLevel']));
            $application->setStatus($this->getReference('application_status_'.$details['status']));
            $this->addReference('application_'.$idx, $application);
            $manager->persist($application);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SwimmingPoolFixtures::class,
            EducationLevelFixtures::class,
            ApplicationStatusFixtures::class,
        ];
    }
}
