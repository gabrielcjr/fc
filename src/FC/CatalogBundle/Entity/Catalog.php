<?php

namespace FC\CatalogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use FC\UserBundle\Entity\User;

/**
 * Catalog
 *
 * @ORM\Table(name="fc_catalog")
 * @ORM\Entity(repositoryClass="FC\CatalogBundle\Repository\CatalogRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Catalog
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="releaseDate", type="datetime")
     */
    private $releaseDate;

    /**
     * @var string
     *
     * @ORM\Column(name="imageName", type="string", length=255)
     */
    private $imageName;

    /**
     * @ORM\ManyToOne(targetEntity="FC\UserBundle\Entity\User", cascade={"remove"}, inversedBy="catalogs")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $author;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @var \DateTime $created
     * 
    //  * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $created;

    /**
     * @var \DateTime $updated
     * 
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $updated;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Catalog
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Catalog
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set releaseDate
     *
     * @param \DateTime $releaseDate
     * @return Catalog
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get releaseDate
     *
     * @return \DateTime 
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * Set imageName
     *
     * @param string $imageName
     * @return Catalog
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string 
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    public function getAuthor(){
        return $this->author;
    }

    public function setAuthor(User $author){
        $this->author = $author;
        return $this;
    }

    public function getSlug(){
        return $this->slug;
    }

    public function setSlug($slug){
        $this->slug = $slug;
    }

    public function getCreated(){
        return $this->created;
    }

    public function setCreated($created){
        $this->created = $created;
    }

    public function getUpdated(){
        return $this->updated;
    }

    public function setUpdated($updated){
        $this->updated = $updated;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist(){
        if(!$this->getCreated()){
            $this->setCreated(new \DateTime());
        }
    }
}
