<?php

namespace App\Entity\Evenement;

use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use App\Utilities\Upload;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement")
 * @ORM\Entity(repositoryClass="App\Repository\Evenement\EvenementRepository")
 * @UniqueEntity(fields="slug", message="Un événement avec cette url existe déjà")
 * @ORM\HasLifecycleCallbacks
 */
class Evenement
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="created", type="datetimetz")
     */
    private $created;

    /**
     * @ORM\Column(name="changed", type="datetimetz", nullable=true)
     */
    private $changed;

    /**
     * @ORM\Column(name="debut", type="datetimetz")
     * @Assert\NotBlank(message="Compléter le champ date de début")
     */
    private $debut;

    /**
     * @ORM\Column(name="fin", type="datetimetz")
     * @Assert\NotBlank(message="Compléter le champ date de fin")
     */
    private $fin;

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
     * @ORM\Column(name="resume", type="text")
     * @Assert\NotBlank(message="Compléter le champ résumé")
     */
    private $resume;

    /**
     * @ORM\Column(name="contenu", type="text")
     * @Assert\NotBlank(message="Compléter le champ contenu")
     */
    private $contenu;

    /**
     * @Assert\Image(
        minWidth = 640,
        minHeight = 480,
        mimeTypes = {"image/jpeg", "image/png"}),
        maxSize = "3M"
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Evenement\Categorie", inversedBy="evenements")
     */
    private $categorie;

    /**
     * @ORM\Column(name="avant", type="boolean")
     */
    private $avant;

    /**
     * @ORM\Column(name="langue", type="string", length=8)
     * @Assert\NotBlank(message="Compléter le champ langue")
     */
    private $langue;

    public function __construct()
    {
        $this->isActive = true;
        $this->created = new \DateTime();
        $this->avant = false;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Evenement
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set changed
     *
     * @param \DateTime $changed
     *
     * @return Evenement
     */
    public function setChanged($changed)
    {
        $this->changed = $changed;

        return $this;
    }

    /**
     * Get changed
     *
     * @return \DateTime
     */
    public function getChanged()
    {
        return $this->changed;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preChanged()
    {
        $this->changed = new \DateTime();
    }

    /**
     * Set debut
     *
     * @param \DateTime $debut
     *
     * @return Evenement
     */
    public function setDebut($debut)
    {
        $this->debut = $debut;

        return $this;
    }

    /**
     * Get debut
     *
     * @return \DateTime
     */
    public function getDebut()
    {
        return $this->debut;
    }

    /**
     * Set fin
     *
     * @param \DateTime $fin
     *
     * @return Evenement
     */
    public function setFin($fin)
    {
        $this->fin = $fin;

        return $this;
    }

    /**
     * Get fin
     *
     * @return \DateTime
     */
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Evenement
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Evenement
     */
    public function setSlug($slug)
    {
        $slugify = new Slugify();
        $this->slug = $slugify->slugify($slug);

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set resume
     *
     * @param string $resume
     *
     * @return Evenement
     */
    public function setResume($resume)
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * Get resume
     *
     * @return string
     */
    public function getResume()
    {
        return $this->resume;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Evenement
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Actualite
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
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
        // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
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
        $size = new Box(375,225);
        $imagine->open($this->fileimage)
                ->thumbnail($size, 'outbound')
                ->save($this->getUploadRootDir().'miniature/'.$this->image);

    }

    public function getUploadRootDir()
    {
        return __DIR__.'/../../../public/img/evenement/';
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Evenement
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Retourne 1 si actif 0 si pas actif
     */
    public function reverseState()
    {
        $etat = $this->getIsActive();

        return !$etat;
    }

    /**
     * Set avant
     *
     * @param boolean $avant
     *
     * @return Evenement
     */
    public function setAvant($avant)
    {
        $this->avant = $avant;

        return $this;
    }

    /**
     * Get avant
     *
     * @return boolean
     */
    public function getAvant()
    {
        return $this->avant;
    }

    /**
     * Set referencement
     *
     * @param \App\Entity\Referencement\Referencement $referencement
     *
     * @return Evenement
     */
    public function setReferencement(\App\Entity\Referencement\Referencement $referencement = null)
    {
        $this->referencement = $referencement;

        return $this;
    }

    /**
     * Get referencement
     *
     * @return \App\Entity\Referencement\Referencement
     */
    public function getReferencement()
    {
        return $this->referencement;
    }

    /**
     * Set categorie
     *
     * @param \App\Entity\Evenement\Categorie $categorie
     *
     * @return Evenement
     */
    public function setCategorie(\App\Entity\Evenement\Categorie $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \App\Entity\Evenement\Categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @return string
     */
    public function getLangue()
    {
        return $this->langue;
    }

    /**
     * @param string $langue
     */
    public function setLangue($langue)
    {
        $this->langue = $langue;
    }
}
