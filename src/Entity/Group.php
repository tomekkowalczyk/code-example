<?php

namespace App\Entity;

use App\Utils\Slugger;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GroupRepository")
 * @ORM\Table(name="groups")
 * @UniqueEntity(fields={"id"})
 */
class Group
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1000)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 3,
     *      max = 120
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Length(
     *      min = 3,
     *      max = 120
     * )
     */
    private $slug;

    /**
     * @ORM\column(type="integer")
     * @Assert\NotBlank
     */
    private $price = 0;

    /**
     * @ORM\column(type="integer")
     * @Assert\NotBlank
     */
    private $minCount = 0;

    /**
     * @ORM\column(type="integer")
     * @Assert\NotBlank
     */
    private $maxCount = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $poolPath = 0;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(
     *      max = 5000
     * )
     */
    private $description;

    /**
     * @ORM\Column(name="create_date", type="datetime")
     * @Assert\NotBlank
     */
    private $createDate;

    /**
     * @ORM\Column(name="start_date", type="datetime")
     * @Assert\NotBlank
     */
    private $startDate;

    /**
     * @ORM\Column(name="end_date", type="datetime")
     * @Assert\NotBlank
     */
    private $endDate;

    /**
     * @ORM\ManyToOne(
     *      targetEntity = "SwimmingPool",
     *      inversedBy = "group"
     * )
     *
     * @ORM\JoinColumn(
     *      name = "swimming_pool_id",
     *      referencedColumnName = "id",
     *      onDelete = "SET NULL"
     * )
     *
     * @Assert\NotBlank
     */
    private $swimmingPool;

    /**
     * @ORM\ManyToOne(
     *      targetEntity = "EducationLevel",
     *      inversedBy = "group"
     * )
     *
     * @ORM\JoinColumn(
     *      name = "education_level_id",
     *      referencedColumnName = "id",
     *      onDelete = "SET NULL"
     * )
     *
     * @Assert\NotBlank
     */
    private $educationLevel;

    /**
     * @ORM\ManyToOne(
     *      targetEntity = "Term",
     *      inversedBy = "group"
     * )
     *
     * @ORM\JoinColumn(
     *      name = "term_id",
     *      referencedColumnName = "id",
     *      onDelete = "SET NULL"
     * )
     *
     * @Assert\NotBlank
     */
    private $term;

    /**
     * @ORM\ManyToOne(
     *      targetEntity = "User",
     *      inversedBy = "coach"
     * )
     *
     * @ORM\JoinColumn(
     *      name = "coach_id",
     *      referencedColumnName = "id",
     *      onDelete = "SET NULL"
     * )
     *
     * @Assert\NotBlank
     */
    private $coach;

    /**
     * @ORM\ManyToMany(
     *      targetEntity = "User",
     *      inversedBy = "groups"
     * )
     *
     * @ORM\JoinTable(
     *      name = "group_students"
     * )
     *
     * @Assert\Count(
     *      min=0,
     *      max=20
     * )
     * @Assert\NotBlank
     */
    private $students;

    /**
     * @ORM\OneToMany(
     *      targetEntity = "Training",
     *      mappedBy = "group",
     *      cascade={"persist"}
     * )
     */
    protected $training;


    /**
     * @ORM\ManyToMany(targetEntity="Group", mappedBy="arrearGroup")
     */
    private $group;

    /**
     * @ORM\ManyToMany(targetEntity="Group", inversedBy="group")
     * @ORM\JoinTable(name="arrear_groups",
     *      joinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="arrear_group", referencedColumnName="id")}
     *      )
     */
    private $arrearGroup;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->createDate = new \DateTime();
        $this->students = new ArrayCollection();
        $this->training = new ArrayCollection();
        $this->arrearGroup = new ArrayCollection();
        $this->group = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    public function setCreateDate(\DateTimeInterface $createDate): self
    {
        $this->createDate = $createDate;

        return $this;
    }

    public function getSwimmingPool(): ?SwimmingPool
    {
        return $this->swimmingPool;
    }

    public function setSwimmingPool(?SwimmingPool $swimmingPool): self
    {
        $this->swimmingPool = $swimmingPool;

        return $this;
    }

    public function getEducationLevel(): ?EducationLevel
    {
        return $this->educationLevel;
    }

    public function setEducationLevel(?EducationLevel $educationLevel): self
    {
        $this->educationLevel = $educationLevel;

        return $this;
    }

    public function getTerm(): ?Term
    {
        return $this->term;
    }

    public function setTerm(?Term $term): self
    {
        $this->term = $term;

        return $this;
    }

    public function getMinCount(): ?int
    {
        return $this->minCount;
    }

    public function setMinCount(int $minCount): self
    {
        $this->minCount = $minCount;

        return $this;
    }

    public function getMaxCount(): ?int
    {
        return $this->maxCount;
    }

    public function setMaxCount(int $maxCount): self
    {
        $this->maxCount = $maxCount;

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

    /**
     * @return Collection|Training[]
     */
    public function getTraining(): Collection
    {
        return $this->training;
    }

    public function addTraining(Training $training): self
    {
        if (!$this->training->contains($training)) {
            $this->training[] = $training;
            $training->setGroup($this);
        }

        return $this;
    }

    public function removeTraining(Training $training): self
    {
        if ($this->training->contains($training)) {
            $this->training->removeElement($training);
            // set the owning side to null (unless already changed)
            if ($training->getGroup() === $this) {
                $training->setGroup(null);
            }
        }

        return $this;
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

    public function getPoolPath(): ?string
    {
        return $this->poolPath;
    }

    public function setPoolPath(string $poolPath): self
    {
        $this->poolPath = $poolPath;

        return $this;
    }


    public function setSlug(string $slug): self
    {
        $this->slug = Slugger::sluggify($slug);

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function __toString()
    {
        return $this->getName();
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
            $group->addGroup($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        if ($this->group->contains($group)) {
            $this->group->removeElement($group);
            $group->removeGroup($this);
        }

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getArrearGroup(): Collection
    {
        return $this->arrearGroup;
    }

    public function addArrearGroup(Group $arrearGroup): self
    {
        if (!$this->arrearGroup->contains($arrearGroup)) {
            $this->arrearGroup[] = $arrearGroup;
        }

        return $this;
    }

    public function removeArrearGroup(Group $arrearGroup): self
    {
        if ($this->arrearGroup->contains($arrearGroup)) {
            $this->arrearGroup->removeElement($arrearGroup);
        }

        return $this;
    }
}
