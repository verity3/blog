<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BlogPostTags
 *
 * @ORM\Table(name="blog_tag_link")
 * @ORM\Entity(repositoryClass="BlogBundle\Entity\BlogPostTagsRepository")
 * 
 */
class BlogPostTags {
    
      /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned": true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;   


    /**
     * @var BlogBundle\Entity\Tags
     *
     * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\Tags", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tagId", referencedColumnName="tagsId")
     * })
     */
    private $tag;    


    /**
     * @var BlogBundle\Entity\BlogPost
     *
     * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\BlogPost", inversedBy="tags", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="blogPostId", referencedColumnName="blogPostId", onDelete="CASCADE")
     * })
     */
    private $blogPost;

  

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
     * Set tag
     *
     * @param \BlogBundle\Entity\Tags $tag
     *
     * @return BlogPostTags
     */
    public function setTag(\BlogBundle\Entity\Tags $tag = null)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return \BlogBundle\Entity\Tags
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set blogPost
     *
     * @param \BlogBundle\Entity\BlogPost $blogPost
     *
     * @return BlogPostTags
     */
    public function setBlogPost(\BlogBundle\Entity\BlogPost $blogPost = null)
    {
        $this->blogPost = $blogPost;

        return $this;
    }

    /**
     * Get blogPost
     *
     * @return \BlogBundle\Entity\BlogPost
     */
    public function getBlogPost()
    {
        return $this->blogPost;
    }
}
