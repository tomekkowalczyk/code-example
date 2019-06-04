<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RegistrationApplicationRepository")
 * @ORM\Table(name="registration_applications")
 * @ORM\HasLifecycleCallbacks
 */
class RegistrationApplication
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
     * @ORM\Column(type="string", length=120)
     * @Assert\NotBlank
     * @Assert\Length(
     *      max = 120
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=120)
     * @Assert\Length(
     *      max = 120
     * )
     */
    private $surname;

    /**
     * @var date
     *
     * @ORM\Column(name="birthday", type="date")
     */
    private $birthday;

    /**
     * @ORM\Column(type="string", length=120)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $phone;

    /**
     * @ORM\ManyToOne(
     *      targetEntity = "SwimmingPool",
     *      inversedBy = "application"
     * )
     *
     * @ORM\JoinColumn(
     *      name = "swimming_pool_id",
     *      referencedColumnName = "id",
     *      onDelete = "SET NULL"
     * )
     *
     * @Assert\NotBlank
     *
     * )
     */
    private $swimmingPool;

    /**
     * @ORM\ManyToOne(
     *      targetEntity = "EducationLevel",
     *      inversedBy = "application"
     * )
     *
     * @ORM\JoinColumn(
     *      name = "education_level_id",
     *      referencedColumnName = "id",
     *      onDelete = "SET NULL"
     * )
     *
     * @Assert\NotBlank
     *
     * )
     */
    private $educationLevel;

    /**
     * @ORM\Column(name="create_date", type="datetime")
     */
    private $createDate;

    /**
     * Comment is text for coach/administrator.
     *
     * @ORM\Column(type="string", length=1000, nullable=true)
     * @Assert\Length(
     *      max = 1000
     * )
     */
    private $comment;

    /**
     * Description is text for students.
     *
     * @ORM\Column(type="string", length=1000, nullable=true)
     * @Assert\Length(
     *      max = 1000
     * )
     */
    private $description;

    /**
     * @ORM\ManyToOne(
     *      targetEntity = "ApplicationStatus",
     *      inversedBy = "applications"
     * )
     *
     * @ORM\JoinColumn(
     *      name = "status_id",
     *      referencedColumnName = "id",
     *      onDelete = "SET NULL"
     * )
     *
     * @Assert\NotBlank
     */
    private $status;

    /**
     * @ORM\Column(type="boolean")
     */
    private $unread = true;

    /**
     * @ORM\Column(type="boolean")
     */
    private $registered = false;

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

    public function setCreateDate(\DateTimeInterface $createDate): self
    {
        $this->createDate = $createDate;

        return $this;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    public function setSwimmingPool(?SwimmingPool $swimmingPool): self
    {
        $this->swimmingPool = $swimmingPool;

        return $this;
    }

    public function getSwimmingPool(): ?SwimmingPool
    {
        return $this->swimmingPool;
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

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return SwimmingPool|null
     */
    public function getPool(): ?SwimmingPool
    {
        return $this->pool;
    }

    /**
     * @param SwimmingPool|null $pool
     *
     * @return RegistrationApplication
     */
    public function setPool(?SwimmingPool $pool): self
    {
        $this->pool = $pool;

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

    public function getStatus(): ?ApplicationStatus
    {
        return $this->status;
    }

    public function setStatus(?ApplicationStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUnread(): ?bool
    {
        return $this->unread;
    }

    public function setUnread(bool $unread): self
    {
        $this->unread = $unread;

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

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

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

    public function getRegistered(): ?bool
    {
        return $this->registered;
    }

    public function setRegistered(bool $registered): self
    {
        $this->registered = $registered;

        return $this;
    }
}
