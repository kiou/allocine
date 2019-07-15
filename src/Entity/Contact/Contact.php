<?php

namespace App\Entity\Contact;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Contact
 *
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="App\Repository\Contact\ContactRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Contact
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
     * @Assert\NotBlank(message="contact.validators.nom")
     */
    private $nom;

    /**
     * @ORM\Column(name="prenom", type="string", length=255)
     * @Assert\NotBlank(message="contact.validators.prenom")
     */
    private $prenom;

    /**
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\NotBlank(message="contact.validators.email")
     * @Assert\Email(message="contact.valiadtors.emailvalide")
     */
    private $email;

    /**
     * @ORM\Column(name="message", type="text")
     * @Assert\NotBlank(message="contact.validators.message")
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Contact\Objet", inversedBy="contacts")
     * @Assert\NotBlank(message="contact.validators.objet")
     */
    private $objet;

    /**
     * @ORM\Column(name="langue", type="string", length=8)
     * @Assert\NotBlank(message="Compléter le champ langue")
     */
    private $langue;

    public function __construct()
    {
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
     * @return Contact
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
     * @return Contact
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
     * @return Contact
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Contact
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Contact
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Contact
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set objet
     *
     * @param \App\Entity\Contact\Objet $objet
     *
     * @return Contact
     */
    public function setObjet(\App\Entity\Contact\Objet $objet = null)
    {
        $this->objet = $objet;

        return $this;
    }

    /**
     * Get objet
     *
     * @return \App\Entity\Contact\Objet
     */
    public function getObjet()
    {
        return $this->objet;
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
