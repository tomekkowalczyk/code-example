<?php

namespace App\DataFixtures;

use App\Entity\Term;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class TermFixtures.
 */
class TermFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $TermsList = [
            [
                'name' => 'Semestr 09-11.18',
                'slug' => 'semestr_1',
                'startDate' => '2018-06-10',
                'endDate' => '2018-07-30',
            ],
            [
                'name' => 'Semestr 09-11.18',
                'slug' => 'semestr_2',
                'startDate' => '2018-09-10',
                'endDate' => '2018-11-30',
            ],
            [
                'name' => 'Semestr 01-02.19',
                'slug' => 'semestr_3',
                'startDate' => '2019-01-12',
                'endDate' => '2019-02-31',
            ],
            [
                'name' => 'Semestr 03-05.19',
                'slug' => 'semestr_4',
                'startDate' => '2019-03-15',
                'endDate' => '2019-05-19',
            ],

        ];

        foreach ($TermsList as $idx => $details) {
            $term = new Term();

            $term->setName($details['name'])
                ->setSlug($details['slug'])
                ->setStartDate(new \DateTime($details['startDate']))
                ->setEndDate(new \DateTime($details['endDate']));

            $manager->persist($term);
            $this->addReference('term_'.$details['slug'], $term);
        }

        $manager->flush();
    }
}
