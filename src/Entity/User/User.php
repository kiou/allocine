<?php

namespace App\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use App\Utilities\Upload;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Repository\User\UserRepository")
 * @UniqueEntity(fields="email", message="user.validators.uniqueemail")
 * @UniqueEntity(fields="nickname", message="user.validators.uniquenickname")
 * @ORM\HasLifecycleCallbacks
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var date
     *
     * @ORM\Column(name="changed", type="datetime", nullable=true)
     */
    private $changed;

     /**
     * @ORM\Column(name="nickname", type="string", length=191, unique=true)
     * @Assert\NotBlank(message="user.validators.nickname")
     */
    private $nickname;

    /**
     * @ORM\Column(name="username", type="string", length=255, nullable=true)
     */
    private $username;

    /**
     * @ORM\Column(name="nom", type="string", length=255)
     * @Assert\NotBlank(message="user.validators.nom")
     */
    private $nom;

    /**
     * @ORM\Column(name="prenom", type="string", length=255)
     * @Assert\NotBlank(message="user.validators.prenom")
     */
    private $prenom;

    /**
     * @ORM\Column(name="password", type="string", length=64)
     * @Assert\NotBlank(message="user.validators.password")
     */
    private $password;

    /**
     * @ORM\Column(name="email", type="string", length=191, unique=true)
     * @Assert\NotBlank(message="user.validators.email")
     * @Assert\Email(message="user.validators.emailvalide")
     */
    private $email;

    /**
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(name="roles", type="array")
     * @Assert\NotBlank(message="user.validators.rolemin")
     */
    private $roles = array();

    /**
     * @Assert\Image(
        minWidth = 150,
        maxWidth = 150,
        minHeight = 150,
        maxHeight = 150,
        mimeTypes = {"image/jpeg", "image/png"}),
        maxSize = "1M"
     */
    private $file;

    /**
     * @var string
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     */
    private $avatar;

    /* Configuration */
    public function __construct(){
        $this->isActive = false;
        $this->created = new \DateTime();
        $this->roles = array('ROLE_USER');
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return date
     */
    public function getChanged()
    {
        return $this->changed;
    }

    /**
     * @param date $changed
     */
    public function setChanged($changed)
    {
        $this->changed = $changed;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preChanged()
    {
        $this->changed = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param mixed $nickname
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
    

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
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
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile(File $file = null)
    {
        $this->file = $file;
        if (null !== $this->avatar){
            $this->avatar = null;
        }

        $this->file = $file;
    }


    /**
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * @param string $avatar
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    public function uploadAvatar()
    {
        // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
        if (is_null($this->file)) {
            return;
        }

        // On récupère le nom original du fichier de l'internaute
        $upload = new Upload();
        $name = $upload->createName(
            $this->file->getClientOriginalName(),
            $this->getUploadRootDir().'/',
            array('avatar/')
        );

        // On déplace le fichier envoyé dans le répertoire de notre choix
        $this->file->move($this->getUploadRootDir().'avatar/', $name);

        /* On enregistre le nom de l'image dans l'entité */
        $this->avatar = $name;
    }

    /**
     * On retourne le chemin relatif vers l'image pour notre code PHP
     */
    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../public/img/user/';
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            ) = unserialize($serialized, ['allowed_classes' => false]);
    }

    public function eraseCredentials()
    {
    }

    public function getSalt()
    {
        return null;
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

}
