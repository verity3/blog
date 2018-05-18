<?php

namespace NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Files
 *
 * @ORM\Table(name="files")
 * @ORM\Entity(repositoryClass="NewsBundle\Repository\FilesRepository")
 */
class Files
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
     * @ORM\Column(name="file", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Please, upload a file.")
     * @ Assert\File(mimeTypes={ "application/pdf" })
     */
    private $file;
    
    /**
     *
     * @return Files
     */
    function getNews() {
        return $this->news;
    }
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
     * Set file
     *
     * @param string $file
     *
     * @return Files
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }
    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }
    }
