<?php

namespace Noona\StockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Produit
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Noona\StockBundle\Entity\ProduitRepository")
 * @UniqueEntity("reference")
 */

class Produit
{

    /**
     * @ var Image
     *@Assert\Valid()
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist"})
     */

    private $image;


    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="reference", type="string", length=255, unique = true)
     */
    private $reference;



    /**
     * @var integer
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/\d+/")
     * @ORM\Column(name="stock", type="integer")
     */
    private $stock;

    /**
     * @var integer
     * @ORM\Column(name="isActif", type="boolean")
     */
    private $isActif;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }


    public function __construct()
    {
        $this->setStock(0);
        $this->setIsActif(1);
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return Produit
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string 
     */
    public function getReference()
    {
        return $this->reference;
    }


    /**
     * Get revenuTotal
     *
     * @return integer 
     */
    public function getRevenuTotal()
    {
        return;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     * @return Produit
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return integer 
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return mixed
     */
    public function getIsActif()
    {
        return $this->isActif;
    }

    /**
     * @param mixed $isActif
     */
    public function setIsActif($isActif)
    {
        $this->isActif = $isActif;
    }


}
