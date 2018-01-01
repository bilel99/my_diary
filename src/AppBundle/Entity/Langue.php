<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Langue
 *
 * @ORM\Table(name="langue")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LangueRepository")
 */
class Langue
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
     * @var array
     * @ORM\OneToOne(targetEntity="Actu", mappedBy="langue")
     */
    public $actu;

    /**
     * @var array
     * @ORM\OneToOne(targetEntity="Categorie", mappedBy="langue")
     */
    public $categorie;

    /**
     * @var array
     * @ORM\OneToOne(targetEntity="Diary", mappedBy="langue")
     */
    private $diary;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=45)
     */
    private $code;

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
     * Set code
     *
     * @param string $code
     *
     * @return Langue
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Langue
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
     * @return Langue
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Set actu
     *
     * @param \AppBundle\Entity\Actu $actu
     *
     * @return Langue
     */
    public function setActu(\AppBundle\Entity\Actu $actu = null)
    {
        $this->actu = $actu;

        return $this;
    }

    /**
     * Get actu
     *
     * @return \AppBundle\Entity\Actu
     */
    public function getActu()
    {
        return $this->actu;
    }

    /**
     * Set categorie
     *
     * @param \AppBundle\Entity\Categorie $categorie
     *
     * @return Langue
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
     * Set diary
     *
     * @param \AppBundle\Entity\Diary $diary
     *
     * @return Langue
     */
    public function setDiary(\AppBundle\Entity\Diary $diary = null)
    {
        $this->diary = $diary;

        return $this;
    }

    /**
     * Get diary
     *
     * @return \AppBundle\Entity\Diary
     */
    public function getDiary()
    {
        return $this->diary;
    }

    public function __toString()
    {
        return $this->name;
    }
}
