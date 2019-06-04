<?php

namespace App\DataFixtures;

use App\Entity\Training;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class TrainingFixtures.
 */
class TrainingFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $trainingList = [
            [
                'uid' => '1503191641',
                'group' => 'number_1',
                'startDate' => '2019-03-08 16:00',
                'endDate' => '2019-03-08 16:40',
                'students' => [513532, 513533, 513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191642',
                'group' => 'number_1',
                'startDate' => '2019-03-15 16:45',
                'endDate' => '2019-03-15 17:30',
                'students' => [513532, 513533],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191643',
                'group' => 'number_1',
                'startDate' => '2019-03-22 18:00',
                'endDate' => '2019-03-22 19:00',
                'students' => [513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191644',
                'group' => 'number_1',
                'startDate' => '2019-03-29 16:00',
                'endDate' => '2019-03-29 17:00',
                'students' => [513532],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191645',
                'group' => 'number_1',
                'startDate' => '2019-04-01 16:00',
                'endDate' => '2019-04-01 17:00',
                'students' => [],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191646',
                'group' => 'number_1',
                'startDate' => '2019-04-08 16:00',
                'endDate' => '2019-04-08 17:00',
                'students' => [513532, 513536, 513537],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191647',
                'group' => 'number_1',
                'startDate' => '2019-04-12 16:00',
                'endDate' => '2019-04-12 17:00',
                'students' => [513532, 513536, 513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191648',
                'group' => 'number_1',
                'startDate' => '2019-04-19 16:00',
                'endDate' => '2019-04-19 17:00',
                'students' => [513532, 513536, 513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191649',
                'group' => 'number_1',
                'startDate' => '2019-04-26 16:00',
                'endDate' => '2019-04-26 17:00',
                'students' => [513532, 513536, 513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191650',
                'group' => 'number_1',
                'startDate' => '2019-05-03 16:00',
                'endDate' => '2019-05-03 17:00',
                'students' => [513536, 513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191651',
                'group' => 'number_1',
                'startDate' => '2019-05-10 16:00',
                'endDate' => '2019-05-10 17:00',
                'students' => [513532, 513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191670',
                'group' => 'number_1',
                'startDate' => '2019-05-17 16:00',
                'endDate' => '2019-05-17 17:00',
                'students' => [513532, 513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191671',
                'group' => 'number_1',
                'startDate' => '2019-05-24 16:00',
                'endDate' => '2019-05-24 17:00',
                'students' => [513532, 513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191672',
                'group' => 'number_1',
                'startDate' => '2019-05-31 16:00',
                'endDate' => '2019-05-31 17:00',
                'students' => [513532, 513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191673',
                'group' => 'number_1',
                'startDate' => '2019-06-07 16:00',
                'endDate' => '2019-06-07 17:00',
                'students' => [513532, 513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191674',
                'group' => 'number_1',
                'startDate' => '2019-06-14 16:00',
                'endDate' => '2019-06-14 17:00',
                'students' => [513532, 513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191675',
                'group' => 'number_1',
                'startDate' => '2019-06-21 16:00',
                'endDate' => '2019-06-21 17:00',
                'students' => [513532, 513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191676',
                'group' => 'number_1',
                'startDate' => '2019-06-28 16:00',
                'endDate' => '2019-06-28 17:00',
                'students' => [513532, 513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191652',
                'group' => 'number_2',
                'startDate' => '2019-03-12 16:00',
                'endDate' => '2019-03-12 17:00',
                'students' => [513532, 513536, 513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191653',
                'group' => 'number_2',
                'startDate' => '2019-03-20 16:00',
                'endDate' => '2019-03-20 17:00',
                'students' => [513536, 513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191654',
                'group' => 'number_2',
                'startDate' => '2019-04-04 16:00',
                'endDate' => '2019-04-04 17:00',
                'students' => [513536, 513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191655',
                'group' => 'number_2',
                'startDate' => '2019-04-25 16:00',
                'endDate' => '2019-04-25 17:00',
                'students' => [513536, 513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191656',
                'group' => 'number_2',
                'startDate' => '2019-05-2 16:00',
                'endDate' => '2019-05-2 17:00',
                'students' => [513536, 513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191657',
                'group' => 'number_2',
                'startDate' => '2019-05-09 16:00',
                'endDate' => '2019-05-09 17:00',
                'students' => [513536, 513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191665',
                'group' => 'number_2',
                'startDate' => '2019-04-28 16:00',
                'endDate' => '2019-04-28 17:00',
                'students' => [513536, 513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191666',
                'group' => 'number_2',
                'startDate' => '2019-05-05 16:00',
                'endDate' => '2019-05-05 17:00',
                'students' => [513536, 513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191667',
                'group' => 'number_2',
                'startDate' => '2019-05-16 16:00',
                'endDate' => '2019-05-16 17:00',
                'students' => [513536, 513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191668',
                'group' => 'number_2',
                'startDate' => '2019-05-23 16:00',
                'endDate' => '2019-05-23 17:00',
                'students' => [513536, 513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191669',
                'group' => 'number_2',
                'startDate' => '2019-05-30 16:00',
                'endDate' => '2019-05-30 17:00',
                'students' => [513534, 513532],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191658',
                'group' => 'number_3',
                'startDate' => '2019-06-08 16:00',
                'endDate' => '2019-06-08 17:00',
                'students' => [513536, 513537],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191659',
                'group' => 'number_3',
                'startDate' => '2019-04-23 16:00',
                'endDate' => '2019-04-23 17:00',
                'students' => [513536, 513537],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191660',
                'group' => 'number_3',
                'startDate' => '2019-04-30 16:00',
                'endDate' => '2019-04-30 17:00',
                'students' => [513536, 513537, 513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191661',
                'group' => 'number_3',
                'startDate' => '2019-05-07 16:00',
                'endDate' => '2019-05-07 17:00',
                'students' => [513536, 513537],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191662',
                'group' => 'number_3',
                'startDate' => '2019-05-14 16:00',
                'endDate' => '2019-05-14 17:00',
                'students' => [513536],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191663',
                'group' => 'number_3',
                'startDate' => '2019-05-23 16:00',
                'endDate' => '2019-05-23 17:00',
                'students' => [513537],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191664',
                'group' => 'number_3',
                'startDate' => '2019-05-28 16:00',
                'endDate' => '2019-05-28 17:00',
                'students' => [513536, 513537, 513534],
                'coach' => 513540,
            ],
            [
                'uid' => '1503191680',
                'group' => 'number_3',
                'startDate' => '2019-06-28 16:00',
                'endDate' => '2019-06-28 17:00',
                'students' => [],
                'coach' => 513540,
            ],
        ];

        foreach ($trainingList as $idx => $details) {
            $training = new Training();

            $training->setStartDate(new \DateTime($details['startDate']))
                    ->setEndDate(new \DateTime($details['endDate']))
                    ->setUid($details['uid']);

            $training->setGroup($this->getReference('group_'.$details['group']));
            $training->setCoach($this->getReference('user_'.$details['coach']));

            foreach ($details['students'] as $student) {
                $training->addStudent($this->getReference('user_'.$student));
            }

            $this->addReference('training_'.$details['uid'], $training);
            $manager->persist($training);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            GroupFixtures::class,
            UserFixtures::class,
        ];
    }
}
