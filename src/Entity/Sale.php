<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Sale
 *
 * @ORM\Table(name="sale")
 * @ORM\Entity(repositoryClass="App\Repository\SaleRepository")
 */
class Sale
{
    const STATUS_ACTIVE = "active";
    const STATUS_FINISHED = "finished";
    const STATUS_CANCELLED = "cancelled";

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank(
     *     message="Tytuł nie może być pusty"
     * )
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="Tytuł nie może być krótszy niż 3 znaki",
     *     maxMessage="Tytuł nie może być dłuższy niż 255 znaków"
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank(
     *     message="Opis nie może być pusty"
     * )
     * @Assert\Length(
     *     min=10,
     *     minMessage="Opis nie może być krótszy niż 10 znaków"
     * )
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="text")
     */
    private $image;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     * @Assert\NotBlank(
     *     message="Cena nie może być pusta"
     * )
     * @Assert\GreaterThan(
     *     value="0",
     *     message="Cena musi być większa od 0"
     * )
     */
    private $price;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expires_at", type="datetime")
     * Assert\NotBlank(
     *     message="Musisz podac datę zakończenia sprzedaży"
     * )
     * @Assert\GreaterThan(
     *     value="+1 day",
     *     message="Sprzedaż nie może kończyć się za mniej niż 24 godziny"
     * )
     */
    private $expiresAt;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=10)
     */
    private $status;

    /**
     * @var Buy[]
     *
     * @ORM\OneToMany(targetEntity="Buy", mappedBy="Sale")
     */
    private $buys;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="sales")
     */
    private $owner;

    /**
     * Sale constructor.
     */
    public function __construct()
    {
        $this->buys = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $title
     *
     * @return Sale
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $description
     *
     * @return Sale
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $image
     *
     * @return $this
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $price
     *
     * @return Sale
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $expiresAt
     *
     * @return $this
     */
    public function setExpiresAt(\DateTime $expiresAt)
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @param $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return Buy[]|ArrayCollection
     */
    public function getBuys()
    {
        return $this->buys;
    }

    /**
     * @param Buy $buy
     *
     * @return $this
     */
    public function addBuy(Buy $buy)
    {
        $this->buys[] = $buy;

        return $this;
    }

    /**
     * @param User $owner
     * 
     * @return $this
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }
}
