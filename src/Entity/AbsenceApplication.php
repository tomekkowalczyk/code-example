<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AbsenceApplicationRepository")
 * @ORM\Table(name="absence_application")
 * @UniqueEntity(fields={"id"})
 */
class AbsenceApplication
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
     * @ORM\Column(name="create_date", type="datetime")
     */
    private $createDate;

    /**
     * @ORM\ManyToOne(
     *      targetEntity = "App\Entity\User",
     *      inversedBy = "absence"
     * )
     *
     * @ORM\JoinColumn(
     *      name = "student_id",
     *      referencedColumnName = "id"
     * )
     */
    private $student;

    /**
     * @ORM\ManyToOne(
     *      targetEntity = "App\Entity\Training",
     *      inversedBy = "absenceApplication"
     * )
     *
     * @ORM\JoinColumn(
     *      name = "training_id",
     *      referencedColumnName = "id"
     * )
     */
    protected $training;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->uid = mt_rand(100000, 999999);
        $this->createDate = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStudent(): ?User
    {
        return $this->student;
    }

    public function setStudent(?User $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getTraining(): ?Training
    {
        return $this->training;
    }

    public function setTraining(?Training $training): self
    {
        $this->training = $training;

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
}
