<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="users")
 * @ORM\HasLifecycleCallbacks
 */
class User implements UserInterface
{
    /**
     * The unique auto incremented primary key.
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", unique=true)
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
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $points;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $wallet;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     *
     * @Assert\Email(
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password bcrypt
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length = 50)
     *
     * @Assert\NotBlank(
     *      groups = {"Registration", "ChangeDetails"}
     * )
     *
     * @Assert\Length(
     *      min=3,
     *      max=50,
     *      groups = {"Registration", "ChangeDetails"}
     * )
     *
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length = 50)
     *
     * @Assert\NotBlank(
     *      groups = {"Registration", "ChangeDetails"}
     * )
     *
     * @Assert\Length(
     *      min=3,
     *      max=50,
     *      groups = {"Registration", "ChangeDetails"}
     * )
     *
     * @var string
     */
    protected $surname;

    /**
     * @ORM\Column(type="string", length = 10000, nullable=true)
     * @Assert\Length(
     *      max=10000,
     * )
     *
     * @var string detailed description of the user available to the application administrator
     */
    protected $description;

    /**
     * @ORM\Column(name="account_locked", type="boolean")
     *
     * @var bool
     */
    protected $accountLocked = false;

    /**
     * @var date
     *
     * @ORM\Column(name="birthday", type="date", nullable=true)
     */
    private $birthday;

    /**
     * @ORM\Column(name="register_date", type="datetime")
     *
     * @var \DateTime
     */
    protected $createDate;

    /**
     * @ORM\Column(type="string", length = 100, nullable = true)
     *
     * @var string
     */
    protected $avatar;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     * @Assert\Length(
     *      max = 20,
     *      min = 7
     * )
     *
     * @var string
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     * @Assert\Length(
     *      max = 120,
     *      min = 3
     * )
     *
     * @var string
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     * @Assert\Length(
     *      max = 120,
     *      min = 3
     * )
     *
     * @var string
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     * @Assert\Length(
     *      max = 10,
     *      min = 4
     * )
     *
     * @var string
     */
    private $postalCode;

    /**
     * @ORM\ManyToMany(
     *      targetEntity = "Group",
     *      mappedBy = "students"
     * )
     */
    protected $groups;

    /**
     * @ORM\ManyToMany(
     *      targetEntity = "Training",
     *      mappedBy = "students"
     * )
     */
    protected $trainings;

    /**
     * @ORM\OneToMany(
     *      targetEntity = "Training",
     *      mappedBy = "coach"
     * )
     */
    protected $training;

    /**
     * @ORM\OneToMany(
     *      targetEntity = "AbsenceApplication",
     *      mappedBy = "student"
     * )
     */
    protected $absence;

    /**
     * @ORM\OneToMany(
     *      targetEntity = "Group",
     *      mappedBy = "coach"
     * )
     * @ORM\OneToMany(
     *      targetEntity = "Training",
     *      mappedBy = "coach"
     * )
     */
    protected $coach;

    /**
     * @ORM\OneToMany(
     *      targetEntity = "Notification",
     *      mappedBy = "user"
     * )
     */
    protected $notification;

    /**
     * @ORM\ManyToOne(
     *      targetEntity = "EducationLevel",
     *      inversedBy = "student"
     * )
     *
     * @ORM\JoinColumn(
     *      name = "education_level_id",
     *      referencedColumnName = "id",
     *      onDelete = "SET NULL"
     * )
     */
    private $educationLevel;

    /**
     * @ORM\OneToMany(
     *      targetEntity = "Payment",
     *      mappedBy = "student"
     * )
     */
    protected $payment;

    /**
     * @ORM\OneToMany(
     *      targetEntity = "Testimonial",
     *      mappedBy = "student"
     * )
     */
    protected $testimonial;

    /**
     * @ORM\OneToMany(
     *      targetEntity = "Post",
     *      mappedBy = "author"
     * )
     */
    protected $post;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUid(): ?int
    {
        return $this->uid;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * User constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->registerDate = new \DateTime();
        $this->uid = mt_rand(100000, 999999);
        $this->students = new ArrayCollection();
        $this->coach = new ArrayCollection();
        $this->groups = new ArrayCollection();
        $this->payment = new ArrayCollection();
        $this->training = new ArrayCollection();
        $this->trainings = new ArrayCollection();
        $this->arrear = new ArrayCollection();
        $this->testimonial = new ArrayCollection();
        $this->post = new ArrayCollection();
        $this->absence = new ArrayCollection();
        $this->notification = new ArrayCollection();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
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

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setAccountLocked(bool $accountLocked): self
    {
        $this->accountLocked = $accountLocked;

        return $this;
    }

    public function getAccountLocked(): ?bool
    {
        return $this->accountLocked;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @return string
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
        ]);
    }

    /**
     * @param $serialized
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password
            ) = unserialize($serialized);
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
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

    public function setUid(int $uid): self
    {
        $this->uid = $uid;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Group $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->addStudent($this);
        }

        return $this;
    }

    public function removeStudent(Group $student): self
    {
        if ($this->students->contains($student)) {
            $this->students->removeElement($student);
            $student->removeStudent($this);
        }

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getCoach(): Collection
    {
        return $this->coach;
    }

    public function addCoach(Group $coach): self
    {
        if (!$this->coach->contains($coach)) {
            $this->coach[] = $coach;
            $coach->setCoach($this);
        }

        return $this;
    }

    public function removeCoach(Group $coach): self
    {
        if ($this->coach->contains($coach)) {
            $this->coach->removeElement($coach);
            // set the owning side to null (unless already changed)
            if ($coach->getCoach() === $this) {
                $coach->setCoach(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Group[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(Group $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
            $group->addStudent($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
            $group->removeStudent($this);
        }

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

    /**
     * @return Collection|Payment[]
     */
    public function getPayment(): Collection
    {
        return $this->payment;
    }

    public function addPayment(Payment $payment): self
    {
        if (!$this->payment->contains($payment)) {
            $this->payment[] = $payment;
            $payment->setStudent($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): self
    {
        if ($this->payment->contains($payment)) {
            $this->payment->removeElement($payment);
            // set the owning side to null (unless already changed)
            if ($payment->getStudent() === $this) {
                $payment->setStudent(null);
            }
        }

        return $this;
    }

    public function addTraining(Training $training): self
    {
        if (!$this->training->contains($training)) {
            $this->training[] = $training;
            $training->setCoach($this);
        }

        return $this;
    }

    public function removeTraining(Training $training): self
    {
        if ($this->training->contains($training)) {
            $this->training->removeElement($training);
            // set the owning side to null (unless already changed)
            if ($training->getCoach() === $this) {
                $training->setCoach(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Training[]
     */
    public function getTrainings(): Collection
    {
        return $this->trainings;
    }

    public function setBirthday(?\DateTime $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getBirthday(): ?\DateTime
    {
        return $this->birthday;
    }

    /**
     * @return Collection|Training[]
     */
    public function getTraining(): Collection
    {
        return $this->training;
    }

    /**
     * @return Collection|Testimonial[]
     */
    public function getTestimonial(): Collection
    {
        return $this->testimonial;
    }

    public function addTestimonial(Testimonial $testimonial): self
    {
        if (!$this->testimonial->contains($testimonial)) {
            $this->testimonial[] = $testimonial;
            $testimonial->setStudent($this);
        }

        return $this;
    }

    public function removeTestimonial(Testimonial $testimonial): self
    {
        if ($this->testimonial->contains($testimonial)) {
            $this->testimonial->removeElement($testimonial);
            // set the owning side to null (unless already changed)
            if ($testimonial->getStudent() === $this) {
                $testimonial->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPost(): Collection
    {
        return $this->post;
    }

    public function addPost(Post $post): self
    {
        if (!$this->post->contains($post)) {
            $this->post[] = $post;
            $post->setAuthor($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->post->contains($post)) {
            $this->post->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getAuthor() === $this) {
                $post->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|AbsenceApplication[]
     */
    public function getAbsence(): Collection
    {
        return $this->absence;
    }

    public function addAbsence(AbsenceApplication $absence): self
    {
        if (!$this->absence->contains($absence)) {
            $this->absence[] = $absence;
            $absence->setStudent($this);
        }

        return $this;
    }

    public function removeAbsence(AbsenceApplication $absence): self
    {
        if ($this->absence->contains($absence)) {
            $this->absence->removeElement($absence);
            // set the owning side to null (unless already changed)
            if ($absence->getStudent() === $this) {
                $absence->setStudent(null);
            }
        }

        return $this;
    }

    public function getWallet(): ?int
    {
        return $this->wallet;
    }

    public function setWallet(?int $wallet): self
    {
        $this->wallet = $wallet;

        return $this;
    }

    /**
     * @return Collection|Notification[]
     */
    public function getNotification(): Collection
    {
        return $this->notification;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notification->contains($notification)) {
            $this->notification[] = $notification;
            $notification->setUser($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notification->contains($notification)) {
            $this->notification->removeElement($notification);
            // set the owning side to null (unless already changed)
            if ($notification->getUser() === $this) {
                $notification->setUser(null);
            }
        }

        return $this;
    }
}
