<?php

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Historique
 *
 * @ORM\Table(name="user_historique")
 * @ORM\Entity(repositoryClass="App\Repository\User\HistoriqueRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Historique
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
     * @ORM\Column(name="contenu", type="text")
     * @Assert\NotBlank(message="Compléter le champ contenu")
     */
    private $contenu;

    /**
     * @ORM\Column(name="ip", type="string", length=255)
     * @Assert\NotBlank(message="Compléter le champ ip")
     */
    private $ip;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User")
     */
    private $utilisateur;

    public function __construct(){
        $this->created = new \DateTime();
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
     * @return Historique
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
     * @return Historique
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
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Historique
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
     * Set utilisateur
     *
     * @param \App\Entity\User\User $utilisateur
     *
     * @return Historique
     */
    public function setUtilisateur(\App\Entity\User\User $utilisateur = null)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \App\Entity\User\User
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return Historique
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }
}
