<?php

namespace App\Entity\Personne;

use App\Entity\Film\Film;
use App\Entity\Galerie\Galerie;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Cocur\Slugify\Slugify;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Personne\PersonneRepository")
 * @UniqueEntity(fields="slug", message="Un acteur/réalisateur avec cette url existe déjà")
 * @ORM\HasLifecycleCallbacks
 */
class Personne
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
     * @Assert\NotBlank(message="Compléter le champ nom")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Compléter le champ prénom")
     */
    private $prenom;

    /**
     * @ORM\Column(name="slug", type="string", length=191, unique=true)
     * @Assert\NotBlank(message="Compléter le champ slug")
     */
    private $slug;

     /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Film\Film", mappedBy="acteurs")
     */
    private $filmacteurs;

     /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Film\Film", mappedBy="realisateurs")
     */
    private $filmrealisateurs;

     /**
     * @ORM\OneToOne(targetEntity="App\Entity\Referencement\Referencement", cascade={"persist","remove"})
     * @Assert\Valid
     */
    private $referencement;

    public function __construct(){
        $this->created = new \DateTime;
        $this->filmacteurs = new ArrayCollection();
        $this->filmrealisateurs = new ArrayCollection();
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

    /**
     * Get the value of changed
     */ 
    public function getChanged()
    {
        return $this->changed;
    }

    /**
     * Set the value of changed
     *
     * @return  self
     */ 
    public function setChanged($changed)
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

    /**
     * Get the value of created
     */ 
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set the value of created
     *
     * @return  self
     */ 
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    public function displayNameForm(){
        return $this->prenom.' '.$this->nom;
    }

    /**
     * @return Collection|Film[]
     */
    public function getFilmacteurs(): Collection
    {
        return $this->filmacteurs;
    }

    public function addFilmacteur(Film $filmacteur): self
    {
        if (!$this->filmacteurs->contains($filmacteur)) {
            $this->filmacteurs[] = $filmacteur;
            $filmacteur->addActeur($this);
        }

        return $this;
    }

    public function removeFilmacteur(Film $filmacteur): self
    {
        if ($this->filmacteurs->contains($filmacteur)) {
            $this->filmacteurs->removeElement($filmacteur);
            $filmacteur->removeActeur($this);
        }

        return $this;
    }

    /**
     * @return Collection|Film[]
     */
    public function getFilmrealisateurs(): Collection
    {
        return $this->filmrealisateurs;
    }

    public function addFilmrealisateur(Film $filmrealisateur): self
    {
        if (!$this->filmrealisateurs->contains($filmrealisateur)) {
            $this->filmrealisateurs[] = $filmrealisateur;
            $filmrealisateur->addRealisateur($this);
        }

        return $this;
    }

    public function removeFilmrealisateur(Film $filmrealisateur): self
    {
        if ($this->filmrealisateurs->contains($filmrealisateur)) {
            $this->filmrealisateurs->removeElement($filmrealisateur);
            $filmrealisateur->removeRealisateur($this);
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $slugify = new Slugify();
        $this->slug = $slugify->slugify($slug);

        return $this;
    }

    public function getReferencement()
    {
        return $this->referencement;
    }

    public function setReferencement($referencement)
    {
        $this->referencement = $referencement;

        return $this;
    }

}
