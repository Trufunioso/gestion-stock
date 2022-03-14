<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 10, unique: true)]
    private $reference;

    #[ORM\Column(type: 'date')]
    private $updateDate;

    #[ORM\Column(type: 'date')]
    private $creationDate;

    #[ORM\Column(type: 'smallint')]
    private $etat;

    //cascade: ['persist'] permet de sauvegarder une commande et un client en même temps
    #[ORM\ManyToOne(targetEntity: 'App\Entity\Client')]
    #[ORM\JoinColumn(nullable: false)]
    private $client;
//
//    #[ORM\ManyToOne(targetEntity: 'App\Entity\Produit')]
//    #[ORM\JoinColumn(nullable: false)]
//    private $produit;

//    /**
//     * @return mixed
//     */
//    public function getProduit()
//    {
//        return $this->produit;
//    }
//
//    /**
//     * @param mixed $produit
//     * @return Commande
//     */
//    public function setProduit($produit)
//    {
//        $this->produit = $produit;
//        return $this;
//    }


    /**
     * @var LigneCommande[]
     */
    #[ORM\OneToMany(targetEntity: 'App\Entity\LigneCommande', mappedBy: 'commande')]
    private $lignes;

    public function __construct() {
        $this->lignes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param mixed $reference
     * @return Commande
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * @param mixed $updateDate
     * @return Commande
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param mixed $creationDate
     * @return Commande
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param mixed $etat
     * @return Commande
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     * @return Commande
     */
    public function setClient($client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getLignes(): ArrayCollection
    {
        return $this->lignes;
    }

    /**
     * @param LigneCommande[] $lignes
     * @return Commande
     */
    public function setLignes(array $lignes): Commande
    {
        $this->lignes = $lignes;
        return $this;
    }

    public function addLigne(LigneCommande $ligne) {
        $this->lignes->add($ligne);
    }

    public function removeLigne(LigneCommande $ligne) {
        $this->lignes->remove($ligne);
    }

}
