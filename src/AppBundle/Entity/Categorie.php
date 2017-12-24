<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategorieRepository")
 */
class Categorie
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
     * @var Langue
     * @ORM\OneToOne(targetEntity="Langue", inversedBy="categorie")
     * @ORM\JoinColumn(name="langue_id", referencedColumnName="id")
     */
    private $langue;

    /**
     * @var array
     * @ORM\OneToMany(targetEntity="Diary", mappedBy="categorie")
     */
    private $diary;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;


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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Categorie
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
     * Constructor
     */
    public function __construct()
    {
        $this->diary = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set langue
     *
     * @param \AppBundle\Entity\Langue $langue
     *
     * @return Categorie
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
     * Add diary
     *
     * @param \AppBundle\Entity\Diary $diary
     *
     * @return Categorie
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
