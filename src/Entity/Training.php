<?php

namespace App\Entity;

use App\Utils\Slugger;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrainingRepository")
 * @ORM\Table(name="trainings")
 * @ORM\HasLifecycleCallbacks
 */
class Training
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * The internal primary identity key.
     *
     * @var int
     *
     * @ORM\Column(type="integer", unique=true)
     */
    private $uid;

    /**
     * @ORM\ManyToOne(
     *      targetEntity = "Group",
     *      inversedBy = "training"
     * )
     *
     * @ORM\JoinColumn(
     *      name = "group_id",
     *      referencedColumnName = "id",
     *      onDelete = "SET NULL"
     * )
     *
     * @Assert\NotBlank
     */
    private $group;

    /**
     * @ORM\ManyToMany(
     *      targetEntity = "User",
     *      inversedBy = "trainings"
     * )
     *
     * @ORM\JoinTable(
     *      name = "training_students"
     * )
     *
     * @Assert\Count(
     *      min=0,
     *      max=20
     * )
     */
    private $students;

    /**
     * @ORM\ManyToOne(
     *      targetEntity = "User",
     *      inversedBy = "training"
     * )
     *
     * @ORM\JoinColumn(
     *      name = "coach_id",
     *      referencedColumnName = "id",
     *      onDelete = "SET NULL"
     * )
     */
    private $coach;

    /**
     * @ORM\Column(name="start_date", type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(name="end_date", type="datetime")
     */
    private $endDate;

    /**
     * @ORM\OneToMany(
     *      targetEntity = "AbsenceApplication",
     *      mappedBy = "training"
     * )
     */
    protected $absenceApplication;

    public function __construct()
    {
        $this->students = new ArrayCollection();
        $this->uid = mt_rand(100000, 999999);
        $this->absenceApplication = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getGroup(): ?Group
    {
        return $this->group;
    }

    public function setGroup(?Group $group): self
    {
        $this->group = $group;

        return $this;
    }

    public function getAbsence(): ?bool
    {
        return $this->absence;
    }

    public function setAbsence(bool $absence): self
    {
        $this->absence = $absence;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(User $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
        }

        return $this;
    }

    public function removeStudent(User $student): self
    {
        if ($this->students->contains($student)) {
            $this->students->removeElement($student);
        }

        return $this;
    }

    public function getCoach(): ?User
    {
        return $this->coach;
    }

    public function setCoach(?User $coach): self
    {
        $this->coach = $coach;

        return $this;
    }

    public function getUid(): ?int
    {
        return $this->uid;
    }

    public function setUid(int $uid): self
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * @return Collection|AbsenceApplication[]
     */
    public function getAbsenceApplication(): Collection
    {
        return $this->absenceApplication;
    }

    public function addAbsenceApplication(AbsenceApplication $absenceApplication): self
    {
        if (!$this->absenceApplication->contains($absenceApplication)) {
            $this->absenceApplication[] = $absenceApplication;
            $absenceApplication->setTraining($this);
        }

        return $this;
    }

    public function removeAbsenceApplication(AbsenceApplication $absenceApplication): self
    {
        if ($this->absenceApplication->contains($absenceApplication)) {
            $this->absenceApplication->removeElement($absenceApplication);
            // set the owning side to null (unless already changed)
            if ($absenceApplication->getTraining() === $this) {
                $absenceApplication->setTraining(null);
            }
        }

        return $this;
    }
}
