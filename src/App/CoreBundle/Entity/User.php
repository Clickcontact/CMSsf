<?php

namespace App\CoreBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface,
    Symfony\Component\Security\Core\Role\Role,
    Doctrine\ORM\Mapping as ORM;

/**
 * App\CoreBundle\Entity\User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface, \Serializable {

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $username
     *
     * @ORM\Column(name="username", type="string", length=100, nullable=true)
     */
    private $username;

    /**
     * @var string $password
     *
     * @ORM\Column(name="password", type="string", length=100, nullable=true)
     */
    private $password;

    /**
     * @var boolean $enabled
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @var datetime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var datetime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var Team
     *
     * @ORM\ManyToMany(targetEntity="Team", mappedBy="user")
     */
    private $team;

    /**
     * 
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="user")
     */
    private $comments;
    
    public function __construct()
    {
        $this->team = new \Doctrine\Common\Collections\ArrayCollection();
    }
    

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get username
     *
     * @return string $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string $password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * Get enabled
     *
     * @return boolean $enabled
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get createdAt
     *
     * @return datetime $createdAt
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get updatedAt
     *
     * @return datetime $updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add team
     *
     * @param App\CoreBundle\Entity\Team $team
     */
    public function addTeam(\App\CoreBundle\Entity\Team $team)
    {
        $this->team[] = $team;
    }

    /**
     * Get team
     *
     * @return Doctrine\Common\Collections\Collection $team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Add comments
     *
     * @param App\CoreBundle\Entity\Comment $comments
     */
    public function addComments(\App\CoreBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;
    }

    /**
     * Get comments
     *
     * @return Doctrine\Common\Collections\Collection $comments
     */
    public function getComments()
    {
        return $this->comments;
    }
    
    /*
     * 
     */

    public function getSalt() {
        return mb_substr(md5($this->getUsername()), 3, 3);
    }

    public function eraseCredentials() {
        return true;
    }

    public function equals(UserInterface $user) {
        if ($this->getUsername() != $user->getUsername()) {
            return false;
        }

        return true;
    }

    public function getRoles() {
        $roles = array();
        foreach ($this->getTeam() as $team)
            $roles[] = new Role($team->getRole());

        return $roles;
    }

    public function serialize() {
        return serialize(
                array(
                    $this->getUsername()
                )
        );
    }

    public function unserialize($serialized) {

        $arr = unserialize($serialized);
        $this->setUsername($arr[0]);
    }

    /**
     *
     * @ORM\prePersist
     */
    public function setCreatedValue() 
    {
         $this->setCreatedAt(new \DateTime());
    }

    /**
     *
     * @ORM\preUpdate
     */
    public function setUpdatedValue()
    {
         $this->setUpdatedAt(new \DateTime());
    }

}
