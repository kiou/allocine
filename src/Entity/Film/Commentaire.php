<?php

namespace App\Entity\Film;

use App\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Film\CommentaireRepository")
 */
class Commentaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
    * @ORM\Column(type="integer")
    */
    private $rating;

    /**
     * @ORM\Column(type="text")
     */
    private $commentaire;

     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Film\Film", inversedBy="commentaires")
     */
    private $film;

     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User", inversedBy="commentaires")
     */
    private $user;

    public function __construct(){
        $this->created = new \DateTime;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get /*
     */ 
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set /*
     *
     * @return  self
     */ 
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get /*
     */ 
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set /*
     *
     * @return  self
     */ 
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getFilm(): ?Film
    {
        return $this->film;
    }

    public function setFilm(?Film $film): self
    {
        $this->film = $film;

        return $this;
    }

}
