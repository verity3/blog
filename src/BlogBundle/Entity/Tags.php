<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use BlogBundle\Extension\Entity\Secure;

/**
 * Tags
 *
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="BlogBundle\Entity\TagsRepository")
 * @ORM\HasLifecycleCallbacks
 * 
 */
class Tags  {
    
    use Secure;
    
     /**
     * @var integer
     *
     * @ORM\Column(name="tagsId", type="integer", options={"unsigned": true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
     /**
     * @var string
     *
     * @ORM\Column(name="tagsName", type="string", length=50)
     */
    private $name;
    
  

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
     *
     * @return Tags
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
}
