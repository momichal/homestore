<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Sale[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Sale", mappedBy="owner")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $sales;

    /**
     * @var Buy[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Buy", mappedBy="owner")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     */
    private $buys;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->sales = new ArrayCollection();
        $this->buys = new ArrayCollection();
    }

    /**
     * @return Sale[]|ArrayCollection
     */
    public function getSales()
    {
        return $this->sales;
    }

    /**
     * @param Sale $sale
     *
     * @return $this
     */
    public function addSale(Sale $sale)
    {
        $this->sales[] = $sale;

        return $this;
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
}
