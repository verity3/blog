<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use BlogBundle\Extension\Entity\Secure;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * BlogPost
 *
 * 
 * @ORM\Table(name="blog_post")
 * @ORM\Entity(repositoryClass="BlogBundle\Entity\BlogPostRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(
 *      fields={"url"},
 *      errorPath="url",
 *      message="This url is already in use.",
 *      groups={"blog_post"},
 * )
 * 
 */
class BlogPost {

    use Secure;

    const ACTIVE = 1;
    const UNACTIVE = null;

    /**
     * @var integer
     * 
     * @ORM\Column(name="blogPostId", type="integer", options={"unsigned": true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * 
     */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="postTitle", type="string", length=150, nullable=false)
     *
     * @Assert\NotBlank(groups={"blog_post"})
     * @Assert\Length(
     *      min = 2,
     *      max = 150,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters",
     *      groups={"blog_post"}
     * )
     */
    private $title;

    /**
     * @var \DateTime
     * @Assert\NotBlank(groups={"blog_post"})
     *
     * @ORM\Column(name="blogPostDate", type="datetime")
     * 
     */
    private $date;

    /**
     * @var text $text
     *
     * @ORM\Column(name="blogPostText", type="text", nullable=false)
     *
     * @Assert\NotBlank(groups={"blog_post"})
     */
    private $text;

    /**
     * @var string $active
     *
     * @ORM\Column(name="active", type="boolean", nullable=false, options={"default" : 0})
     */
    private $active;

    /**
     * @var integer $visits
     *
     * @ORM\Column(name="visits", type="integer", nullable=false, options={"unsigned": true})
     */
    private $visits;
    
    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=false)
     * 
     * @Assert\NotBlank(groups={"blog_post"})
     * @Assert\Regex(
     *     pattern="/^([a-z0-9\-]+)$/i",
     *     groups={"blog_post"},
     *     message="Url field can contain only letters, digits and -"
     * )
     */
    private $url;

    /**
     * @var BlogBundle\Entity\BlogPostTags
     *
     * @ORM\OneToMany(targetEntity="BlogBundle\Entity\BlogPostTags", mappedBy="blogPost", cascade={"all"})
     */
    private $tags;

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
        $this->tags = new ArrayCollection;
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
     * @return BlogPost
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
     * @return BlogPost
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
     * @return BlogPost
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
     * @return BlogPost
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
     * Set visits
     *
     * @param integer $visits
     *
     * @return BlogPost
     */
    public function setVisits($visits)
    {
        $this->visits = $visits;

        return $this;
    }

    /**
     * Get visits
     *
     * @return integer
     */
    public function getVisits()
    {
        return $this->visits;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return BlogPost
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
     * @return BlogPost
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
     * Set url
     *
     * @param string $url
     *
     * @return BlogPost
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Add tag
     *
     * @param \BlogBundle\Entity\BlogPostTags $tag
     *
     * @return BlogPost
     */
    public function addTag(\BlogBundle\Entity\BlogPostTags $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \BlogBundle\Entity\BlogPostTags $tag
     */
    public function removeTag(\BlogBundle\Entity\BlogPostTags $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }
}
