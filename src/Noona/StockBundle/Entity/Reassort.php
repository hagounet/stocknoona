<?php

namespace Noona\StockBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Reassort
 *
 * @ORM\Table()
 * * @ORM\Entity(repositoryClass="Noona\StockBundle\Entity\ReassortRepository")
 */
class Reassort
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $dateReassort;


    /**
     *
     * @ORM\Column(name="coutsDivers",type="float")
     * @Assert\Regex(pattern="/\d+/", message="ceci doit être un nombre")
     */
    private $coutsDivers;

    /**
     * @ORM\OneToMany(targetEntity="Noona\StockBundle\Entity\ReassortProduit", mappedBy="reassort", cascade={"all"})
     * @Assert\Valid()
     */
    private $reassortProduits;

    /**
     * @param int $coutsDivers
     */
    public function setCoutsDivers($coutsDivers)
    {
        $this->coutsDivers = $coutsDivers;

        return $this;
    }

    /**
     * @return int
     *
     */
    public function getCoutsDivers()
    {
        return $this->coutsDivers;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="totalPrice", type="float")
     */
    private $totalPrice;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Reassort
     */
    public function setDateReassort($dateReassort)
    {
        $this->dateReassort = $dateReassort;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDateReassort()
    {
        return $this->dateReassort;
    }

    /**
     * Set totalPrice
     *
     * @param integer $totalPrice
     * @return Reassort
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Get totalPrice
     *
     * @return integer 
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setDateReassort(new \Datetime());
        $this->setCoutsDivers(0);
        $this->setTotalPrice(0);
    }

    /**
     * Add reassortProduits
     *
     * @param \Noona\StockBundle\Entity\ReassortProduit $reassortProduits
     * @return Reassort
     */
    public function addReassortProduit(\Noona\StockBundle\Entity\ReassortProduit $reassortProduits)
    {
        $this->reassortProduits[] = $reassortProduits;
        $reassortProduits->setReassort($this);

        return $this;
    }

    /**
     * Remove reassortProduits
     *
     * @param \Noona\StockBundle\Entity\ReassortProduit $reassortProduits
     */
    public function removeReassortProduit(\Noona\StockBundle\Entity\ReassortProduit $reassortProduits)
    {
        $this->reassortProduits->removeElement($reassortProduits);
    }

    /**
     * Get reassortProduits
     *
     * @return \Doctrine\Common\Collections\Collection
     * @Assert\NotBlank()
     * @Assert\Valid()
     */
    public function getReassortProduits()
    {
        return $this->reassortProduits;
    }
}
