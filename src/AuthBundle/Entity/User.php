<?php

namespace AuthBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AuthBundle\Entity\UserRepository")
 * @ORM\HasLifecycleCallbacks
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * 
     */
    private $username;

    /**
     *
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * 
     *
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;
    
    /**
     * @var string $active
     *
     * @ORM\Column(type="boolean", nullable=false, options={"default" : 0})
     */
    private $active;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     */
    private $passwordTemp;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     */
    private $code;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     */
    private $rememberToken;
    
    


    public function __construct() {
        $this->roles = array('ROLE_USER');
    }

    // other properties and methods

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getUsername()
    {
         return $this->email;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
        $this->password = null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getSalt()
    {
        
        return null;
    }
    
    

    public function getRoles()
    {
        return $this->roles;
    }

    public function eraseCredentials()
    {
         $this->plainPassword = null;
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
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Set passwordTemp
     *
     * @param string $passwordTemp
     *
     * @return User
     */
    public function setPasswordTemp($passwordTemp)
    {
        $this->passwordTemp = $passwordTemp;

        return $this;
    }

    /**
     * Get passwordTemp
     *
     * @return string
     */
    public function getPasswordTemp()
    {
        return $this->passwordTemp;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return User
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
     * Set rememberToken
     *
     * @param string $rememberToken
     *
     * @return User
     */
    public function setRememberToken($rememberToken)
    {
        $this->rememberToken = $rememberToken;

        return $this;
    }

    /**
     * Get rememberToken
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->rememberToken;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return User
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
}
