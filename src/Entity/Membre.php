<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MembreRepository")
 * @UniqueEntity(fields={"email"},errorPath="email",message="cet email existe dejà")
 */
class Membre implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Saisissez votre nom")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Saisissez votre prénom")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message="Saisissez votre email")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(message="n'oubliez pas votre mot de passe")
     * @Assert\Regex(pattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]+$/")
     * @Assert\Length(min="8", minMessage="votre mot de passe doit contenir {{ limit }} caractères au minimum",max="20",maxMessage="votre mot de passe est trop long. {{ limit } caractère max")
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
    private $roles=[];

    /**
     * @Assert\IsTrue(message="vous devez validez nos CGU")
     */
    private $conditions;

    /**
     * @return mixed
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * @param mixed $conditions
     * @return Membre
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;
        return $this;
    }


    /**
     * Membre constructor.
     * @param string $role
     * @throws \Exception
     */
    public function __construct(string $role = 'ROLE_MEMBRE')
    {
        $this->article = new ArrayCollection();
        $this->dateInscription = new \DateTime();
        $this->addRole($role);

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

    public function setDerniereConnection(string $timestamp ='now'): self
    {
        $this->derniereConnection = new \DateTime($timestamp);

        return $this;
    }



    public function addRole(string $role):bool
    {
        if(!in_array($role, $this->roles)){
            $this->roles[] = $role;
            return true;
        }else{
            return false;
        }
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




    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param mixed $roles
     * @return Membre
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }

}
