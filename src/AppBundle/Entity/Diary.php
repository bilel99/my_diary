<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Diary
 *
 * @ORM\Table(name="diary")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DiaryRepository")
 */
class Diary
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
     * @var Users
     * @ORM\ManyToOne(targetEntity="Users", inversedBy="diary")
     * @ORM\JoinColumn(name="users_id", referencedColumnName="id")
     */
    private $users;

    /**
     * @var Categorie
     * @ORM\ManyToOne(targetEntity="Categorie", inversedBy="diary")
     * @ORM\JoinColumn(name="categorie_id", referencedColumnName="id", nullable=true)
     */
    private $categorie;

    /**
     * @var Langue
     * @ORM\OneToOne(targetEntity="Langue", inversedBy="diary")
     * @ORM\JoinColumn(name="langue_id", referencedColumnName="id")
     */
    private $langue;

    /**
     * @var Media
     * @ORM\ManyToMany(targetEntity="Media", inversedBy="diary", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="media_id", referencedColumnName="id", nullable=true)
     */
    public $media;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text", nullable=true)
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="date", nullable=true)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date", nullable=true)
     */
    private $dateFin;

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
     * Set titre
     *
     * @param string $titre
     *
     * @return Diary
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
     * @return Diary
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
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Diary
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Diary
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Diary
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Diary
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->media = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set users
     *
     * @param \AppBundle\Entity\Users $users
     *
     * @return Diary
     */
    public function setUsers(\AppBundle\Entity\Users $users = null)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Get users
     *
     * @return \AppBundle\Entity\Users
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set categorie
     *
     * @param \AppBundle\Entity\Categorie $categorie
     *
     * @return Diary
     */
    public function setCategorie(\AppBundle\Entity\Categorie $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \AppBundle\Entity\Categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set langue
     *
     * @param \AppBundle\Entity\Langue $langue
     *
     * @return Diary
     */
    public function setLangue(\AppBundle\Entity\Langue $langue = null)
    {
        $this->langue = $langue;

        return $this;
    }

    /**
     * Get langue
     *
     * @return \AppBundle\Entity\Langue
     */
    public function getLangue()
    {
        return $this->langue;
    }

    /**
     * Add medium
     *
     * @param \AppBundle\Entity\Media $medium
     *
     * @return Diary
     */
    public function addMedia(\AppBundle\Entity\Media $medium)
    {
        $this->media[] = $medium;

        return $this;
    }

    /**
     * Remove medium
     *
     * @param \AppBundle\Entity\Media $medium
     */
    public function removeMedia(\AppBundle\Entity\Media $medium)
    {
        $this->media->removeElement($medium);
    }

    /**
     * Get media
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMedia()
    {
        return $this->media;
    }
}
