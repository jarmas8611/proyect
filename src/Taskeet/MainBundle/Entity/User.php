<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rafix
 * Date: 22/04/13
 * Time: 23:38
 * To change this template use File | Settings | File Templates.
 */

namespace Taskeet\MainBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Taskeet\MainBundle\Entity\Department;
use Symfony\Bridge\Doctrine\Validator\Constraints as Assert; 

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @Assert\UniqueEntity("username") 
 * @Assert\UniqueEntity("email") 
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var datetime $created
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var datetime $updated
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\ManyToMany(targetEntity="Group")
     * @ORM\JoinTable(name="fos_user_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

     /**
      * @ORM\ManyToMany(targetEntity="Project", mappedBy="members")
      */
     protected $projects;

     /**
      * @ORM\OneToMany(targetEntity="Ticket", mappedBy="assignedTo")
      */
     protected $tasks;

     /**
      * @ORM\Column(type="string", length=32, nullable=true)
      */
     protected $firstName;

     /**
      * @ORM\Column(type="string", length=32, nullable=true)
      */
     protected $lastName;

    /**
     * @ORM\OneToOne(targetEntity="Department", mappedBy="owner")
     */
    protected $jefeDpto;

    /**
     * @ORM\ManyToOne(targetEntity="Department", inversedBy="users")
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id")
     */
    protected $department;

    public function __construct()
    {
        parent::__construct();
        // your own logic

        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tasks = new \Doctrine\Common\Collections\ArrayCollection();

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
     * Set created
     *
     * @param \DateTime $created
     * @return User
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
     * Set updated
     *
     * @param \DateTime $updated
     * @return User
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

     /**
      * Add projects
      *
      * @param \Taskeet\MainBundle\Entity\Project $projects
      * @return User
      */
     public function addProject(\Taskeet\MainBundle\Entity\Project $projects)
     {
         $this->projects[] = $projects;

         return $this;
     }

     /**
      * Remove projects
      *
      * @param \Taskeet\MainBundle\Entity\Project $projects
      */
     public function removeProject(\Taskeet\MainBundle\Entity\Project $projects)
     {
         $this->projects->removeElement($projects);
     }

     /**
      * Get projects
      *
      * @return \Doctrine\Common\Collections\Collection
      */
     public function getProjects()
     {
         return $this->projects;
     }

     /**
      * Add tasks
      *
      * @param \Taskeet\MainBundle\Entity\Ticket $tasks
      * @return User
      */
     public function addTask(\Taskeet\MainBundle\Entity\Ticket $tasks)
     {
         $this->tasks[] = $tasks;

         return $this;
     }

     /**
      * Remove tasks
      *
      * @param \Taskeet\MainBundle\Entity\Ticket $tasks
      */
     public function removeTask(\Taskeet\MainBundle\Entity\Ticket $tasks)
     {
         $this->tasks->removeElement($tasks);
     }

     /**
      * Get tasks
      *
      * @return \Doctrine\Common\Collections\Collection
      */
     public function getTasks()
     {
         return $this->tasks;
     }

    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    public function getCredentialsExpireAt()
    {
        return $this->credentialsExpireAt;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return sprintf("%s %s", $this->firstName, $this->lastName);
    }

    public function __toString()
    {
        $fullName = $this->getFullName();
        if($fullName === ' ')
            return $this->username;
        else
            return $this->getFullName();
    }

    /**
     * Set jefeDpto
     *
     * @param \Taskeet\MainBundle\Entity\Department $jefeDpto
     * @return User
     */
    public function setJefeDpto(\Taskeet\MainBundle\Entity\Department $jefeDpto = null)
    {
        $this->jefeDpto = $jefeDpto;

        return $this;
    }

    /**
     * Get jefeDpto
     *
     * @return \Taskeet\MainBundle\Entity\Department 
     */
    public function getJefeDpto()
    {
        return $this->jefeDpto;
    }

    /**
     * Set department
     *
     * @param \Taskeet\MainBundle\Entity\Department $department
     * @return User
     */
    public function setDepartment(\Taskeet\MainBundle\Entity\Department $department = null)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return \Taskeet\MainBundle\Entity\Department 
     */
    public function getDepartment()
    {
        return $this->department;
    }
}
