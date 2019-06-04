<?php

namespace App\DataFixtures;

use App\Entity\Group;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class GroupFixtures.
 */
class GroupFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $groupList = [
            [
                'name' => 'Grupa 1/1/KURDW/03-06.19',
                'slug' => 'number_1',
                'price' => 35,
                'minCount' => 3,
                'maxCount' => 10,
                'startDate' => '2019-03-10 16:00',
                'endDate' => '2019-06-31 16:45',
                'description' => 'Lorem ipsun dolor set amint.',
                'swimmingPool' => 'osrodek-sportowo–rekreacyjny-kurdwanów-nowy',
                'educationLevel' => 'poziom_1',
                'coach' => 513540,
                'students' => [513532, 513533, 513534],
                'term' => 'semestr_4',
                'poolPath' => '1',
                'arrear' => ['number_2', 'number_3'],
            ],
            [
                'name' => 'Grupa 2/2/KURDW/03-06.19',
                'slug' => 'number_2',
                'price' => 45,
                'minCount' => 2,
                'maxCount' => 4,
                'startDate' => '2019-03-08 17:00',
                'endDate' => '2019-06-21 17:45',
                'description' => 'Lorem ipsun dolor set amint.',
                'swimmingPool' => 'osrodek-sportowo–rekreacyjny-kurdwanów-nowy',
                'educationLevel' => 'poziom_2',
                'coach' => 513540,
                'students' => [513532, 513535],
                'term' => 'semestr_4',
                'poolPath' => '2',
                'arrear' => ['number_1', 'number_3'],
            ],
            [
                'name' => 'Grupa 2/3/KURDW/03-05.19',
                'slug' => 'number_3',
                'price' => 45,
                'minCount' => 2,
                'maxCount' => 3,
                'startDate' => '2019-03-09 17:00',
                'endDate' => '2019-05-30 17:45',
                'description' => 'Lorem ipsun dolor set amint.',
                'swimmingPool' => 'osrodek-sportowo–rekreacyjny-kurdwanów-nowy',
                'educationLevel' => 'poziom_2',
                'coach' => 513539,
                'students' => [513536, 513537],
                'term' => 'semestr_4',
                'poolPath' => '3',
                'arrear' => ['number_2'],
            ],
            [
                'name' => 'Grupa 1/4/HUTA/03-05.19',
                'slug' => 'number_4',
                'price' => 50,
                'minCount' => 3,
                'maxCount' => 10,
                'startDate' => '2019-03-08 19:00',
                'endDate' => '2019-05-08 20:00',
                'description' => 'Lorem ipsun dolor set amint.',
                'swimmingPool' => 'miedzyszkolny-basen-plywacki-krakow-nowa-huta',
                'educationLevel' => 'poziom_1',
                'coach' => 513539,
                'students' => [513536, 513537, 513538],
                'term' => 'semestr_4',
                'poolPath' => '4',
                'arrear' => ['number_2', 'number_3'],
            ],
            [
                'name' => 'Grupa 1/2/ZSOS/03-05.19',
                'slug' => 'number_5',
                'price' => 50,
                'minCount' => 3,
                'maxCount' => 10,
                'startDate' => '2019-03-08 20:00',
                'endDate' => '2019-05-08 21:00',
                'description' => 'Lorem ipsun dolor set amint.',
                'swimmingPool' => 'obasen-plywacki–zsos',
                'educationLevel' => 'poziom_1',
                'coach' => 513540,
                'students' => [513538, 513536],
                'term' => 'semestr_4',
                'poolPath' => '2',
                'arrear' => ['number_2', 'number_3'],
            ],
            [
                'name' => 'Grupa 3/2/HUTA/03-05.19',
                'slug' => 'number_6',
                'price' => 28,
                'minCount' => 2,
                'maxCount' => 5,
                'startDate' => '2019-03-11 20:00',
                'endDate' => '2019-05-12 21:00',
                'description' => 'Lorem ipsun dolor set amint.',
                'swimmingPool' => 'miedzyszkolny-basen-plywacki-krakow-nowa-huta',
                'educationLevel' => 'poziom_1',
                'coach' => 513540,
                'students' => [],
                'term' => 'semestr_4',
                'poolPath' => '3',
                'arrear' => ['number_1', 'number_2'],
            ],
            [
                'name' => 'Grupa 1/1/KURDW/01-02.19',
                'slug' => 'number_7',
                'price' => 28,
                'minCount' => 2,
                'maxCount' => 5,
                'startDate' => '2019-01-13 20:00',
                'endDate' => '2019-02-15 21:00',
                'description' => 'Lorem ipsun dolor set amint.',
                'swimmingPool' => 'osrodek-sportowo–rekreacyjny-kurdwanów-nowy',
                'educationLevel' => 'poziom_1',
                'coach' => 513540,
                'students' => [],
                'term' => 'semestr_3',
                'poolPath' => '1',
                'arrear' => [],

            ],
            [
                'name' => 'Grupa 3/1/KURDW/01-02.19',
                'slug' => 'number_8',
                'price' => 28,
                'minCount' => 2,
                'maxCount' => 5,
                'startDate' => '2019-01-12 20:00',
                'endDate' => '2019-02-12 21:00',
                'description' => 'Lorem ipsun dolor set amint.',
                'swimmingPool' => 'osrodek-sportowo–rekreacyjny-kurdwanów-nowy',
                'educationLevel' => 'poziom_3',
                'coach' => 513540,
                'students' => [513536, 513537, 513538],
                'term' => 'semestr_3',
                'poolPath' => '1',
                'arrear' => [],
            ],
            [
                'name' => 'Grupa 3/1/KURDW/09-11.18',
                'slug' => 'number_9',
                'price' => 28,
                'minCount' => 2,
                'maxCount' => 5,
                'startDate' => '2018-09-12 20:00',
                'endDate' => '2018-11-12 21:00',
                'description' => 'Lorem ipsun dolor set amint.',
                'swimmingPool' => 'osrodek-sportowo–rekreacyjny-kurdwanów-nowy',
                'educationLevel' => 'poziom_3',
                'coach' => 513540,
                'students' => [513536, 513537, 513538],
                'term' => 'semestr_3',
                'poolPath' => '1',
                'arrear' => [],
            ],
        ];

        foreach ($groupList as $idx => $details) {
            $group = new Group();

            $group->setName($details['name'])
                    ->setSlug($details['slug'])
                    ->setPrice($details['price'])
                    ->setDescription($details['description'])
                    ->setMinCount($details['minCount'])
                    ->setMaxCount($details['maxCount'])
                    ->setPoolPath($details['poolPath'])
                    ->setStartDate(new \DateTime($details['startDate']))
                    ->setEndDate(new \DateTime($details['endDate']))
                ;
            $group->setSwimmingPool($this->getReference('swimming_pool_'.$details['swimmingPool']));
            $group->setEducationLevel($this->getReference('education_level_'.$details['educationLevel']));
            $group->setCoach($this->getReference('user_'.$details['coach']));
            $group->setTerm($this->getReference('term_'.$details['term']));
            foreach ($details['students'] as $student) {
                $group->addStudent($this->getReference('user_'.$student));
            }
            $this->addReference('group_'.$details['slug'], $group);
            $manager->persist($group);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            SwimmingPoolFixtures::class,
            EducationLevelFixtures::class,
            TermFixtures::class,
        ];
    }
}
