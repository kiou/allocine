<?php

namespace App\Entity\Diaporama;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Categorie
 *
 * @ORM\Table(name="galerieimage_categorie")
 * @ORM\Entity(repositoryClass="App\Repository\Diaporama\CategorieRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Categorie
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
     * @ORM\Column(name="nom", type="string", length=255)
     * @Assert\NotBlank(message="Compléter le champ nom")
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Diaporama\Galerie", mappedBy="categorie")
     */
    private $galeries;

    /**
     * @ORM\Column(name="langue", type="string", length=8)
     * @Assert\NotBlank(message="Compléter le champ langue")
     */
    private $langue;

    public function __construct()
    {
        $this->created = new \DateTime();
        $this->galeries = new ArrayCollection();
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
     * @return Categorie
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
     * @return Categorie
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Categorie
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Add galery
     *
     * @param \App\Entity\Diaporama\Galerie $galery
     *
     * @return Categorie
     */
    public function addGalery(\App\Entity\Diaporama\Galerie $galery)
    {
        $this->galeries[] = $galery;

        return $this;
    }

    /**
     * Remove galery
     *
     * @param \App\Entity\Diaporama\Galerie $galery
     */
    public function removeGalery(\App\Entity\Diaporama\Galerie $galery)
    {
        $this->galeries->removeElement($galery);
    }

    /**
     * Get galeries
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGaleries()
    {
        return $this->galeries;
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
