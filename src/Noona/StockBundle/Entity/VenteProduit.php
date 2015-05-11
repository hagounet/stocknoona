<?php

namespace Noona\StockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * VenteProduit
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Noona\StockBundle\Entity\VenteProduitRepository")
 */
class VenteProduit
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Noona\StockBundle\Entity\Vente", inversedBy="venteProduits")
     */

    private $vente;

    /**
     * @var int
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Noona\StockBundle\Entity\Produit")
     */


    private $produit;



    /**
     * @var integer
     *
     * @ORM\Column(name="coutTotal", type="float")
     */
    private $coutTotal;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantite", type="integer")
     * @Assert\Type(type= "digit", message="ceci doit être un nombre entier")
     * @Assert\Range(min = "1" , minMessage="il doit y avoir au moins 1 exemplaire")
     */
    private $quantite;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    function __construct()
    {
        $this->setCoutTotal(0);
        $this->setQuantite(0);
    }
    /**
     * Set vente
     *
     * @param \Noona\StockBundle\Entity\Vente $vente
     * @return VenteProduit
     */
    public function setVente(\Noona\StockBundle\Entity\Vente $vente)
    {
        $this->vente = $vente;

        return $this;
    }

    /**
     * Get vente
     *
     * @return \Noona\StockBundle\Entity\Vente
     */
    public function getVente()
    {
        return $this->vente;
    }

    /**
     * Set produit
     *
     * @param \Noona\StockBundle\Entity\produit $produit
     * @return VenteProduit
     */
    public function setProduit(\Noona\StockBundle\Entity\produit $produit)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return \Noona\StockBundle\Entity\produit 
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * @return int
     */
    public function getCoutTotal()
    {
        return $this->coutTotal;
    }

    /**
     * @param int $coutTotal
     */
    public function setCoutTotal($coutTotal)
    {
        $this->coutTotal = $coutTotal;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * @param int $quantite
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }



}
