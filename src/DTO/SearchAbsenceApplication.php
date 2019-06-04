<?php

namespace App\DTO;

/**
 * Class SearchAbsenceApplication.
 */
class SearchAbsenceApplication
{
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
    public function getStudent()
    {
        return $this->student;
    }
}
