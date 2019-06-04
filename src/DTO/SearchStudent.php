<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class SearchStudent
{
    /**
     * @Assert\Length(
     *      max = 120
     * )
     */
    public $search;

    public $educationLevel;

    /**
     * Get search.
     *
     * @return string search
     */
    public function getSearch(): ?string
    {
        return $this->search;
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
}
