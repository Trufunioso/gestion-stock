<?php

namespace App\Entity;

use App\Repository\AuteurRepository;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;

#[ORM\Entity(repositoryClass: AuteurRepository::class)]
#[ORM\UniqueConstraint(columns: ['nom', 'prenom'])]
class Auteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100, nullable: false)]
    private $nom;

    #[ORM\Column(type: 'string', length: 100, nullable: false)]
    private $prenom;

    #[ORM\Column(type: 'date', nullable: true)]
    private $dateDeNaissance;

    #[ORM\Column(type: 'boolean', nullable: false, options: [ 'default' => 0 ])]
    private $estPrime;

    #[ORM\Column(type: 'text', length: 1000, nullable: true)]
    private $bibliographie;

//    #[ORM\OneToMany(targetEntity: 'App\Entity\Livre', mappedBy: 'auteur')]
//    private $livres;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     * @return Auteur
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     * @return Auteur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateDeNaissance()
    {
        return $this->dateDeNaissance;
    }

    /**
     * @param mixed $dateDeNaissance
     * @return Auteur
     */
    public function setDateDeNaissance($dateDeNaissance)
    {
        $this->dateDeNaissance = $dateDeNaissance;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEstPrime()
    {
        return $this->estPrime;
    }

    /**
     * @param mixed $estPrime
     * @return Auteur
     */
    public function setEstPrime($estPrime)
    {
        $this->estPrime = $estPrime;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBibliographie()
    {
        return $this->bibliographie;
    }

    /**
     * @param mixed $bibliographie
     * @return Auteur
     */
    public function setBibliographie($bibliographie)
    {
        $this->bibliographie = $bibliographie;
        return $this;
    }


}
