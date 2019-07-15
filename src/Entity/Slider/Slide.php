<?php

namespace App\Entity\Slider;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use App\Utilities\Upload;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


/**
 * Slide
 *
 * @ORM\Table(name="slide")
 * @ORM\Entity(repositoryClass="App\Repository\Slider\SlideRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Slide
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
     * @ORM\Column(name="titre", type="string", length=255)
     * @Assert\NotBlank(message="Compléter le champ titre")
     */
    private $titre;

    /**
     * @ORM\Column(name="contenu", type="text")
     * @Assert\NotBlank(message="Compléter le champ contenu")
     */
    private $contenu;

    /**
     * @ORM\Column(name="lien", type="string", length=255, nullable=true)
     */
    private $lien;

    /**
     * @Assert\Image(
        minWidth = 640,
        minHeight = 480,
        mimeTypes = {"image/jpeg", "image/png"}),
        maxSize = "3M"
     */
    private $fileimage;

    /**
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(name="poid", type="integer")
     */
    private $poid;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Slider\Slider", inversedBy="slides")
     */
    private $slider;

    public function __construct()
    {
        $this->isActive = true;
        $this->created = new \DateTime();
        $this->poid = 1;
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
     * @return Slide
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
     * @return Slide
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
     * Set titre
     *
     * @param string $titre
     *
     * @return Slide
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
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Slide
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
     * Set lien
     *
     * @param string $lien
     *
     * @return Slide
     */
    public function setLien($lien)
    {
        $this->lien = $lien;

        return $this;
    }

    /**
     * Get lien
     *
     * @return string
     */
    public function getLien()
    {
        return $this->lien;
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

    public function setFileimage(UploadedFile $fileimage)
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
        $size = new Box(1170,600);
        $imagine->open($this->fileimage)
                ->thumbnail($size, 'outbound')
                ->save($this->getUploadRootDir().'miniature/'.$this->image);

    }

    public function getUploadRootDir()
    {
        return __DIR__.'/../../../public/img/slider/slide/';
    }

    /**
     * @Assert\Callback
     */
    public function isFileimageValid(ExecutionContextInterface $context)
    {

        if(empty($this->id)){
            if(empty($this->fileimage)) $context->buildViolation('Complétez le champ image')->atPath('fileimage')->addViolation();
        }

    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Actualite
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
     * Set poid
     *
     * @param integer $poid
     *
     * @return Actualite
     */
    public function setPoid($poid)
    {
        $this->poid = $poid;

        return $this;
    }

    /**
     * Get poid
     *
     * @return integer
     */
    public function getPoid()
    {
        return $this->poid;
    }

    /**
     * Set slider
     *
     * @param \App\Entity\Slider\Slider $slider
     *
     * @return Slide
     */
    public function setSlider(\App\Entity\Slider\Slider $slider = null)
    {
        $this->slider = $slider;

        return $this;
    }

    /**
     * Get slider
     *
     * @return \App\Entity\Slider\Slider
     */
    public function getSlider()
    {
        return $this->slider;
    }
}
