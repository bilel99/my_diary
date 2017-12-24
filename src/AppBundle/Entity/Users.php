<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsersRepository")
 */
class Users
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Ville
     * @ORM\OneToOne(targetEntity="Ville", inversedBy="users")
     * @ORM\JoinColumn(name="ville_id", referencedColumnName="id", nullable=true)
     */
    private $ville;

    /**
     * @var Media
     * @ORM\OneToOne(targetEntity="Media", inversedBy="users")
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id", nullable=true)
     */
    private $media;

    /**
     * @var Role
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="users")
     * @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     */
    private $role;

    /**
     * @var array
     * @ORM\OneToMany(targetEntity="Actu", mappedBy="users")
     */
    private $actu;

    /**
     * @var array
     * @ORM\OneToMany(targetEntity="Diary", mappedBy="users")
     */
    private $diary;

    /**
     * @var string
     *
     * @ORM\Column(name="pseudo", type="string", length=255)
     */
    private $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_naissance", type="date", nullable=true)
     */
    private $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="forgot", type="string", length=255, nullable=true)
     */
    private $forgot;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;


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
     * Set pseudo
     *
     * @param string $pseudo
     *
     * @return Users
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get pseudo
     *
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Users
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
     * Set password
     *
     * @param string $password
     *
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return Users
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set forgot
     *
     * @param string $forgot
     *
     * @return Users
     */
    public function setForgot($forgot)
    {
        $this->forgot = $forgot;

        return $this;
    }

    /**
     * Get forgot
     *
     * @return string
     */
    public function getForgot()
    {
        return $this->forgot;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->actu = new \Doctrine\Common\Collections\ArrayCollection();
        $this->diary = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set ville
     *
     * @param \AppBundle\Entity\Ville $ville
     *
     * @return Users
     */
    public function setVille(\AppBundle\Entity\Ville $ville = null)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return \AppBundle\Entity\Ville
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set media
     *
     * @param \AppBundle\Entity\Media $media
     *
     * @return Users
     */
    public function setMedia(\AppBundle\Entity\Media $media = null)
    {
        $this->media = $media;

        return $this;
    }

    /**
     * Get media
     *
     * @return \AppBundle\Entity\Media
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * Set role
     *
     * @param \AppBundle\Entity\Role $role
     *
     * @return Users
     */
    public function setRole(\AppBundle\Entity\Role $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \AppBundle\Entity\Role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Add actu
     *
     * @param \AppBundle\Entity\Actu $actu
     *
     * @return Users
     */
    public function addActu(\AppBundle\Entity\Actu $actu)
    {
        $this->actu[] = $actu;

        return $this;
    }

    /**
     * Remove actu
     *
     * @param \AppBundle\Entity\Actu $actu
     */
    public function removeActu(\AppBundle\Entity\Actu $actu)
    {
        $this->actu->removeElement($actu);
    }

    /**
     * Get actu
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActu()
    {
        return $this->actu;
    }

    /**
     * Add diary
     *
     * @param \AppBundle\Entity\Diary $diary
     *
     * @return Users
     */
    public function addDiary(\AppBundle\Entity\Diary $diary)
    {
        $this->diary[] = $diary;

        return $this;
    }

    /**
     * Remove diary
     *
     * @param \AppBundle\Entity\Diary $diary
     */
    public function removeDiary(\AppBundle\Entity\Diary $diary)
    {
        $this->diary->removeElement($diary);
    }

    /**
     * Get diary
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDiary()
    {
        return $this->diary;
    }
}
