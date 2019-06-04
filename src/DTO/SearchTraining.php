<?php

namespace App\DTO;

use App\Entity\User;

/**
 * Class SearchTraining.
 */
class SearchTraining
{
    /**
     * @var
     */
    public $swimmingPool;

    /**
     * @var
     */
    public $group;

    /**
     * @var
     */
    public $term;

    /**
     * @var
     */
    public $educationLevel;

    /**
     * @var
     */
    public $coach;

    /**
     * @var
     */
    public $student;

    /**
     * @var \DateTime
     */
    public $startDate;

    /**
     * @return Group|null
     */
    public function getGroup(): ?Group
    {
        return $this->group;
    }

    /**
     * @return App\Entity\Term
     */
    public function getTerm(): ?Term
    {
        return $this->term;
    }

    /**
     * @return mixed
     */
    public function getCoach(): ?User
    {
        return $this->coach;
    }

    /**
     * @return mixed
     */
    public function getStudent(): ?User
    {
        return $this->student;
    }

    /**
     * Get educationLevel.
     *
     * @return App\Entity\EducationLevel
     */
    public function getEducationLevel(): ?EducationLevel
    {
        return $this->educationLevel;
    }

    /**
     * @return SwimmingPool|null
     */
    public function getSwimmingPool(): ?SwimmingPool
    {
        return $this->swimmingPool;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }
}
