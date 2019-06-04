<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EducationLevelRepository")
 * @ORM\Table(name="education_levels")
 */
class EducationLevel extends AbstractTaxonomy
{
    /**
     * @ORM\Column(type="integer", unique=true)
     *
     * @var int level
     */
    private $level;

    /**
     * @ORM\Column(type="text")
     *
     * @var string description
     */
    private $description;

    /**
     * @ORM\OneToMany(
     *      targetEntity = "RegistrationApplication",
     *      mappedBy = "educationLevel"
     * )
     */
    protected $application;

    /**
     * @ORM\OneToMany(
     *      targetEntity = "Group",
     *      mappedBy = "educationLevel"
     * )
     */
    protected $group;

    /**
     * @ORM\OneToMany(
     *      targetEntity = "User",
     *      mappedBy = "educationLevel"
     * )
     */
    protected $student;

    /**
     * EducationLevel constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->application = new ArrayCollection();
        $this->group = new ArrayCollection();
        $this->student = new ArrayCollection();
    }

    public function __toString(): string
    {
        return (string) $this->level;
    }

    /**
     * @return Collection|RegistrationApplication[]
     */
    public function getApplication(): Collection
    {
        return $this->application;
    }

    public function addApplication(RegistrationApplication $application): self
    {
        if (!$this->application->contains($application)) {
            $this->application[] = $application;
            $application->setEducationLevel($this);
        }

        return $this;
    }

    public function removeApplication(RegistrationApplication $application): self
    {
        if ($this->application->contains($application)) {
            $this->application->removeElement($application);
            // set the owning side to null (unless already changed)
            if ($application->getEducationLevel() === $this) {
                $application->setEducationLevel(null);
            }
        }

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getGroup(): Collection
    {
        return $this->group;
    }

    public function addGroup(Group $group): self
    {
        if (!$this->group->contains($group)) {
            $this->group[] = $group;
            $group->setEducationLevel($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        if ($this->group->contains($group)) {
            $this->group->removeElement($group);
            // set the owning side to null (unless already changed)
            if ($group->getEducationLevel() === $this) {
                $group->setEducationLevel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getStudent(): Collection
    {
        return $this->student;
    }

    public function addStudent(User $student): self
    {
        if (!$this->student->contains($student)) {
            $this->student[] = $student;
            $student->setEducationLevel($this);
        }

        return $this;
    }

    public function removeStudent(User $student): self
    {
        if ($this->student->contains($student)) {
            $this->student->removeElement($student);
            // set the owning side to null (unless already changed)
            if ($student->getEducationLevel() === $this) {
                $student->setEducationLevel(null);
            }
        }

        return $this;
    }
}
