<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Media
 *
 * @ORM\Table(name="media")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MediaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Media
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
     * @ORM\OneToOne(targetEntity="Actu", mappedBy="media")
     */
    private $actu;

    /**
     * @var array
     * @ORM\OneToOne(targetEntity="Users", mappedBy="media")
     */
    private $users;

    /**
     * @var array
     * @ORM\ManyToMany(targetEntity="Diary", mappedBy="media")
     */
    private $diary;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=45, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255, nullable=true)
     */
    private $filename;

    // Work private variable
    private $file;

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
     * Set nom
     *
     * @param string $nom
     *
     * @return Media
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
     * @return Media
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
     * @return Media
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
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /*****************************************************
     *
     *                  Step Upload Image
     *
     ****************************************************/
    /**
     * @ORM\PostLoad()
     */
    public function postLoad(){
        $this->updatedAt = new \DateTime();
    }

    public function getUploadRootDir(){
        return __DIR__.'/../../../web/uploads';
    }

    public function getAbsolutePath(){
        return $this->filename === null ? null : $this->getUploadRootDir().'/'.$this->filename;
    }

    public function getAssetFilename(){
        return 'uploads/'.$this->filename;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload(){
        $this->tempFile = $this->getAbsolutePath();
        $this->oldFile = $this->getFilename();
        $this->updatedAt = new \DateTime();

        if($this->file != null) {
            $this->filename = md5(uniqid()).'.'.$this->file->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload(){
        if($this->file !== null) {
            $this->file->move($this->getUploadRootDir(), $this->filename);
            unset($this->file);

            if($this->oldFile != null) {
                unlink($this->tempFile);
            }
        }
    }

    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload(){
        $this->tempFile = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload(){
        if(file_exists($this->tempFile)){
            unlink($this->tempFile);
        }
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->diary = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add diary
     *
     * @param \AppBundle\Entity\Diary $diary
     *
     * @return Media
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

    /**
     * @return array
     */
    public function getActu()
    {
        return $this->actu;
    }

    /**
     * @param array $actu
     */
    public function setActu($actu)
    {
        $this->actu = $actu;
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
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return array
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param array $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }
}
