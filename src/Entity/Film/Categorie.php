<?php

namespace App\Entity\Film;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Film\CategorieRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="categorie_film")
 */
class Categorie
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
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $changed;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

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

    public function getChanged(): ?\DateTimeInterface
    {
        return $this->changed;
    }

    public function setChanged(?\DateTimeInterface $changed): self
    {
        $this->changed = $changed;

        return $this;
    }

     /**
     * @ORM\PreUpdate()
     */
    public function preChanged()
    {
        $this->changed = new \DateTime();
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
}
