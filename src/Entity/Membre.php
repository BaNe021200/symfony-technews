<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MembreRepository")
 */
class Membre
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateInscription;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $derniereConnection;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article",mappedBy="membre")
     */
    private $article;

    /**
     *
     * @ORM\Column(type="array")
     */
    private $role=[];

    /**
     * Membre constructor.
     *
     */
    public function __construct()
    {
        $this->article = new ArrayCollection();
        $this->dateInscription = new \DateTime();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function getDerniereConnection(): ?\DateTimeInterface
    {
        return $this->derniereConnection;
    }

    public function setDerniereConnection(?\DateTimeInterface $derniereConnection): self
    {
        $this->derniereConnection = $derniereConnection;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     * @return Membre
     */
    public function setRole($role)
    {
        $this->role = $role;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param mixed $article
     * @return Membre
     */
    public function setArticle($article)
    {
        $this->article = $article;
        return $this;
    }


}
