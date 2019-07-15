<?php

namespace App\Entity\Slider;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Slider
 *
 * @ORM\Table(name="slider")
 * @ORM\Entity(repositoryClass="App\Repository\Slider\SliderRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Slider
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
     * @ORM\OneToMany(targetEntity="App\Entity\Slider\Slide", mappedBy="slider")
     */
    private $slides;

    /**
     * @ORM\Column(name="langue", type="string", length=8)
     * @Assert\NotBlank(message="Compléter le champ langue")
     */
    private $langue;

    public function __construct()
    {
        $this->created = new \DateTime();
        $this->slides = new ArrayCollection();

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
     * @return Slider
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
     * @return Slider
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
     * @return Slider
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
     * Add slide
     *
     * @param \App\Entity\Slider\Slide $slide
     *
     * @return Slider
     */
    public function addSlide(\App\Entity\Slider\Slide $slide)
    {
        $this->slides[] = $slide;

        return $this;
    }

    /**
     * Remove slide
     *
     * @param \App\Entity\Slider\Slide $slide
     */
    public function removeSlide(\App\Entity\Slider\Slide $slide)
    {
        $this->slides->removeElement($slide);
    }

    /**
     * Get slides
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSlides()
    {
        return $this->slides;
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
