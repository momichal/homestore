<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Buy
 * @ORM\Table(name="buy")
 * @ORM\Entity(repositoryClass="App\Repository\BuyRepository")
 */
class Buy
{
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
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     * @Assert\NotBlank(
     *     message="Cena nie może byc pusta"
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
     * @ORM\Column(name="update_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updateAt;

    /**
     * @var Sale
     *
     * @ORM\ManyToOne(targetEntity="Sale", inversedBy="buys")
     * @ORM\JoinColumn(name="sale_id", referencedColumnName="id")
     */
    private $sale;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="buys")
     */
    private $owner;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Buy
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return Buy
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
     * @param \DateTime $updateAt
     *
     * @return Buy;
     */
    public function setUpdateAt(\DateTime $updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * @param Sale $sale
     *
     * @return $this;
     */
    public function setSale(Sale $sale)
    {
        $this->sale = $sale;

        return $this;
    }

    /**
     * @return Sale
     */
    public function getSale()
    {
        return $this->sale;
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
