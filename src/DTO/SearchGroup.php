<?php

namespace App\DTO;

/**
 * Class SearchGroup.
 */
class SearchGroup
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
    public function getCoach()
    {
        return $this->coach;
    }

    /**
     * @return mixed
     */
    public function getStudent()
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
}
