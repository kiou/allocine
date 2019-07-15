<?php

namespace App\Entity\Film;

use App\Entity\Diaporama\Galerie;
use App\Entity\Personne\Personne;
use App\Entity\Referencement\Referencement;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Cocur\Slugify\Slugify;
use App\Utilities\Upload;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Film\FilmRepository")
 * @UniqueEntity(fields="slug", message="Un film avec cette url existe déjà")
 * @ORM\HasLifecycleCallbacks
 */
class Film
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
     * @ORM\Column(name="titre", type="string", length=255)
     * @Assert\NotBlank(message="Compléter le champ titre")
     */
    private $titre;
    /**
     * @ORM\Column(name="slug", type="string", length=191, unique=true)
     * @Assert\NotBlank(message="Compléter le champ slug")
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="Compléter le champ date de sortie")
     */
    private $datedesortie;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Compléter le champ synopsis")
     */
    private $synopsis;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Compléter le champ bande annonce")
     */
    private $ba;

     /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Personne\Personne", inversedBy="filmacteurs")
     * @ORM\JoinTable(name="film_acteur")
     */
    private $acteurs;

     /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Personne\Personne", inversedBy="filmrealisateurs")
     * @ORM\JoinTable(name="film_realisateur")
     */
    private $realisateurs;

     /**
     * @ORM\OneToOne(targetEntity="App\Entity\Diaporama\Galerie", mappedBy="filmgalerie")
     */
    private $galeriefilm;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Film\Commentaire", mappedBy="film")
     */
    private $commentaires;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Film\Categorie")
     */
    private $categorie;

     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Film\SousCategorie")
     */
    private $souscategorie;

    /**
     * @Assert\Image(
     * minWidth = 640,
     * minHeight = 480,
     * mimeTypes = {"image/jpeg", "image/png"}),
     * maxSize = "3M"
     */
    private $fileimage;
    /**
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Referencement\Referencement", cascade={"persist","remove"})
     * @Assert\Valid
     */
    private $referencement;
    
    /**
     * @ORM\Column(name="langue", type="string", length=8)
     * @Assert\NotBlank(message="Compléter le champ langue")
     */
    private $langue;

    public function __construct(){
        $this->created = new \DateTime;
        $this->isActive = true;
        $this->acteurs = new ArrayCollection();
        $this->acteurs = new ArrayCollection();
        $this->realisateurs = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
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


    public function getDatedesortie()
    {
        return $this->datedesortie;
    }

    public function setDatedesortie($datedesortie)
    {
        $this->datedesortie = $datedesortie;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): self
    {
        $this->synopsis = $synopsis;

        return $this;
    }


    public function setImage($image)
    {
        $this->image = $image;
        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getFileimage()
    {
        return $this->fileimage;
    }

    public function setFileimage(UploadedFile $fileimage = null)
    {
        $this->fileimage = $fileimage;
        if (null !== $this->image){
            $this->image = null;
        }
    }


    public function uploadImage()
    {
        if (null === $this->fileimage) {
            return;
        }

        $upload = new Upload();
        $this->image = $upload->createName(
            $this->fileimage->getClientOriginalName(),
            $this->getUploadRootDir().'/',
            array('tmp/','miniature/')
        );

        $imagine = new Imagine();
        /* Tmp */
        $size = new Box(1920,1080);
        $imagine->open($this->fileimage)
                ->thumbnail($size, 'inset')
                ->save($this->getUploadRootDir().'tmp/'.$this->image);

        /* Miniature */
        $size = new Box(375,600);
        $imagine->open($this->fileimage)
                ->thumbnail($size, 'outbound')
                ->save($this->getUploadRootDir().'miniature/'.$this->image);
    }

    public function getUploadRootDir()
    {
        return __DIR__.'/../../../public/img/film/';
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function reverseState()
    {
        $etat = $this->getIsActive();
        return !$etat;
    }

    public function getReferencement(): ?Referencement
    {
        return $this->referencement;
    }

    public function setReferencement(?Referencement $referencement): self
    {
        $this->referencement = $referencement;

        return $this;
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
        $slugify = new Slugify();
        $this->slug = $slugify->slugify($slug);

        return $this;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }


    /**
     * Get the value of ba
     */ 
    public function getBa()
    {
        return $this->ba;
    }

    /**
     * Set the value of ba
     *
     * @return  self
     */ 
    public function setBa($ba)
    {
        $this->ba = $ba;

        return $this;
    }

    /**
     * @return Collection|Personne[]
     */
    public function getActeurs(): Collection
    {
        return $this->acteurs;
    }

    public function addActeur(Personne $acteur): self
    {
        if (!$this->acteurs->contains($acteur)) {
            $this->acteurs[] = $acteur;
        }

        return $this;
    }

    public function removeActeur(Personne $acteur): self
    {
        if ($this->acteurs->contains($acteur)) {
            $this->acteurs->removeElement($acteur);
        }

        return $this;
    }

   /**
   * @Assert\Callback
   */
    public function isActeursValid(ExecutionContextInterface $context)
    {

        if ($this->acteurs->count() == 0) {
            $context
                ->buildViolation('Selectionner un acteur')
                ->atPath('acteurs')
                ->addViolation();
        }

    }

     /**
     * @Assert\Callback
     */
    public function isRealisateursValid(ExecutionContextInterface $context)
    {

        if ($this->realisateurs->count() == 0) {
            $context
                ->buildViolation('Selectionner un réalisateur')
                ->atPath('realisateurs')
                ->addViolation();
        }

    }

    /**
     * @return Collection|Personne[]
     */
    public function getRealisateurs(): Collection
    {
        return $this->realisateurs;
    }

    public function addRealisateur(Personne $realisateur): self
    {
        if (!$this->realisateurs->contains($realisateur)) {
            $this->realisateurs[] = $realisateur;
        }

        return $this;
    }

    public function removeRealisateur(Personne $realisateur): self
    {
        if ($this->realisateurs->contains($realisateur)) {
            $this->realisateurs->removeElement($realisateur);
        }

        return $this;
    }

    public function getGaleriefilm(): ?Galerie
    {
        return $this->galeriefilm;
    }

    public function setGaleriefilm(?Galerie $galeriefilm): self
    {
        $this->galeriefilm = $galeriefilm;

        // set (or unset) the owning side of the relation if necessary
        $newFilmgalerie = $galeriefilm === null ? null : $this;
        if ($newFilmgalerie !== $galeriefilm->getFilmgalerie()) {
            $galeriefilm->setFilmgalerie($newFilmgalerie);
        }

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setFilm($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->contains($commentaire)) {
            $this->commentaires->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getFilm() === $this) {
                $commentaire->setFilm(null);
            }
        }

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getSouscategorie(): ?SousCategorie
    {
        return $this->souscategorie;
    }

    public function setSouscategorie(?SousCategorie $souscategorie): self
    {
        $this->souscategorie = $souscategorie;

        return $this;
    }

 

}
