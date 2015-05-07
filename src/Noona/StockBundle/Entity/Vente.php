<?php

namespace Noona\StockBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Vente
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Noona\StockBundle\Entity\VenteRepository")
 */
class Vente
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
    private $dateVente;


    /**
     *
     * @ORM\Column(name="coutsDivers",type="float")
     * @Assert\Regex(pattern="/\d+/", message="ceci doit être un nombre")
     */
    private $coutsDivers;

    /**
     * @ORM\OneToMany(targetEntity="Noona\StockBundle\Entity\VenteProduit", mappedBy="vente", cascade={"all"})
     * @Assert\Valid()
     */
    private $venteProduits;

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
     * @return Vente
     */
    public function setDateVente($dateVente)
    {
        $this->dateVente = $dateVente;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDateVente()
    {
        return $this->dateVente;
    }

    /**
     * Set totalPrice
     *
     * @param integer $totalPrice
     * @return Vente
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
        $this->setDateVente(new \Datetime());
        $this->setCoutsDivers(0);
        $this->setTotalPrice(0);
    }

    /**
     * Add venteProduits
     *
     * @param \Noona\StockBundle\Entity\VenteProduit $venteProduits
     * @return Vente
     */
    public function addVenteProduit(\Noona\StockBundle\Entity\VenteProduit $venteProduits)
    {
        $this->venteProduits[] = $venteProduits;
        $venteProduits->setVente($this);

        return $this;
    }

    /**
     * Remove venteProduits
     *
     * @param \Noona\StockBundle\Entity\VenteProduit $venteProduits
     */
    public function removeVenteProduit(\Noona\StockBundle\Entity\VenteProduit $venteProduits)
    {
        $this->venteProduits->removeElement($venteProduits);
    }

    /**
     * Get vente Produits
     *
     * @return \Doctrine\Common\Collections\Collection
     * @Assert\NotBlank()
     * @Assert\Valid()
     */
    public function getVenteProduits()
    {
        return $this->venteProduits;
    }
}
