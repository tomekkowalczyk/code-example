<?php

namespace App\Tests\Utils;

use App\Manager\TrainingManager;
use PHPUnit\Framework\TestCase;

/**
 * Class TrainingManagerTest.
 */
class TrainingManagerTest extends TestCase
{
    private $trainingManager;

    public function setUp()
    {
        $this->trainingManager = new TrainingManager();
    }

    /**
     * @dataProvider getDates
     */
    public function testGenerateTrainingDates(array $dates, array $correctDates)
    {
        $this->assertEquals($correctDates, $this->trainingManager->generateTrainingDates($dates[0], $dates[1]));
    }

    public function getDates()
    {
        yield [[new \DateTime('01-05-2019 16:00'), new \DateTime('05-05-2019 16:00')],
            [['startDate' => new \DateTime('01-05-2019 16:00'), 'endDate' => new \DateTime('01-05-2019 16:45')]],
        ];
        yield [[new \DateTime('01-05-2019 16:00'), new \DateTime('31-05-2019 16:00')],
            [
                ['startDate' => new \DateTime('01-05-2019 16:00'), 'endDate' => new \DateTime('01-05-2019 16:45')],
                ['startDate' => new \DateTime('08-05-2019 16:00'), 'endDate' => new \DateTime('08-05-2019 16:45')],
                ['startDate' => new \DateTime('15-05-2019 16:00'), 'endDate' => new \DateTime('15-05-2019 16:45')],
                ['startDate' => new \DateTime('22-05-2019 16:00'), 'endDate' => new \DateTime('22-05-2019 16:45')],
                ['startDate' => new \DateTime('29-05-2019 16:00'), 'endDate' => new \DateTime('29-05-2019 16:45')],
            ],
        ];
        yield [[new \DateTime('03-05-2019 16:00'), new \DateTime('28-06-2019 16:00')],
            [
                ['startDate' => new \DateTime('03-05-2019 16:00'), 'endDate' => new \DateTime('03-05-2019 16:45')],
                ['startDate' => new \DateTime('10-05-2019 16:00'), 'endDate' => new \DateTime('10-05-2019 16:45')],
                ['startDate' => new \DateTime('17-05-2019 16:00'), 'endDate' => new \DateTime('17-05-2019 16:45')],
                ['startDate' => new \DateTime('24-05-2019 16:00'), 'endDate' => new \DateTime('24-05-2019 16:45')],
                ['startDate' => new \DateTime('31-05-2019 16:00'), 'endDate' => new \DateTime('31-05-2019 16:45')],
                ['startDate' => new \DateTime('07-06-2019 16:00'), 'endDate' => new \DateTime('07-06-2019 16:45')],
                ['startDate' => new \DateTime('14-06-2019 16:00'), 'endDate' => new \DateTime('14-06-2019 16:45')],
                ['startDate' => new \DateTime('21-06-2019 16:00'), 'endDate' => new \DateTime('21-06-2019 16:45')],
                ['startDate' => new \DateTime('28-06-2019 16:00'), 'endDate' => new \DateTime('28-06-2019 16:45')],
            ],
        ];
    }
}
