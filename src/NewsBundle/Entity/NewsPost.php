<?php

namespace NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use NewsBundle\Extension\Entity\Secure;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * NewsPost
 *
 * 
 * @ORM\Table(name="news")
 * @ORM\Entity(repositoryClass="NewsBundle\Entity\NewsPostRepository")
 * @ORM\HasLifecycleCallbacks
 * 
 */
class NewsPost {

    use Secure;

    const ACTIVE = 1;
    const UNACTIVE = null;

    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="postTitle", type="string", length=150, nullable=false)
     *
     * @Assert\NotBlank(groups={"news_post"})
     * @Assert\Length(
     *      min = 2,
     *      max = 150,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters",
     *      groups={"news_post"}
     * )
     */
    private $title;

    /**
     * @var \DateTime
     * @Assert\NotBlank(groups={"news_post"})
     *
     * @ORM\Column(name="newsPostDate", type="datetime")
     * 
     */
    private $date;

    /**
     * @var text $text
     *
     * @ORM\Column(name="newsPostText", type="text", nullable=false)
     *
     * @Assert\NotBlank(groups={"news_post"})
     */
    private $text;

    /**
     * @var string $active
     *
     * @ORM\Column(name="active", type="boolean", nullable=false, options={"default" : 0})
     */
    private $active;

    /**
     * @var AuthBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="AuthBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="createdBy", referencedColumnName="id")
     * })
     */
    private $createdBy;

   

    /**
     * @ORM\ManyToMany(targetEntity="Files", cascade={"persist"})
     */
    private $files;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime")
     */
    private $modified;
    
   

    public function __construct() {
        $this->created = new \DateTime;
        $this->modified = new \DateTime;
        $this->date = new \DateTime;
        $this->files = new ArrayCollection;
    }

   

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
     * Set title
     *
     * @param string $title
     *
     * @return NewsPost
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return NewsPost
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return NewsPost
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return NewsPost
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return NewsPost
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
     * Set modified
     *
     * @param \DateTime $modified
     *
     * @return NewsPost
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Set createdBy
     *
     * @param \AuthBundle\Entity\User $createdBy
     *
     * @return NewsPost
     */
    public function setCreatedBy(\AuthBundle\Entity\User $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \AuthBundle\Entity\User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Add file
     *
     * @param \NewsBundle\Entity\Files $file
     *
     * @return NewsPost
     */
    public function addFile(\NewsBundle\Entity\Files $file)
    {
        $this->files[] = $file;

        return $this;
    }

    /**
     * Remove file
     *
     * @param \NewsBundle\Entity\Files $file
     */
    public function removeFile(\NewsBundle\Entity\Files $file)
    {
        $this->files->removeElement($file);
    }

    /**
     * Get files
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFiles()
    {
        return $this->files;
    }
}
