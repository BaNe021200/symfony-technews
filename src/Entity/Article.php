<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous devez saisir un titre")
     * @Assert\Length(max="255",maxMessage="votre message ne doit pas dépasser {{limit}} caractère")
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="vous devez entrer message")
     */
    private $contenu;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="vous devez téléverser une image")
     * @Assert\Image(mimeTypes="image/jpeg",mimeTypes="image/png",maxSize="2M",maxWidthMessage="votre fichier ne doit pas dépasser {{limit}} mo")
     *
     */
    private $featuredImage;

    /**
     * @ORM\Column(type="boolean")
     */
    private $special;

    /**
     * @ORM\Column(type="boolean")
     */
    private $spotlight;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie",inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="vous devez choisir une catégorie")
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Membre",inversedBy="article")
     * @ORM\JoinColumn(nullable=false)
     */
    private $membre;

    /**
     * Article constructor.
     * @param $dateCreation
     * @throws \Exception
     */
    public function __construct()
    {
        $this->dateCreation = new \DateTime();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getFeaturedImage()
    {
        return $this->featuredImage;
    }

    public function setFeaturedImage($featuredImage): void
    {
        $this->featuredImage = $featuredImage;

        //return $this;
    }

    public function getSpecial(): ?bool
    {
        return $this->special;
    }

    public function setSpecial(bool $special): self
    {
        $this->special = $special;

        return $this;
    }

    public function getSpotlight(): ?bool
    {
        return $this->spotlight;
    }

    public function setSpotlight(bool $spotlight): self
    {
        $this->spotlight = $spotlight;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param mixed $categorie
     * @return Article
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMembre()
    {
        return $this->membre;
    }

    /**
     * @param mixed $membre
     * @return Article
     */
    public function setMembre($membre)
    {
        $this->membre = $membre;
        return $this;
    }



}
