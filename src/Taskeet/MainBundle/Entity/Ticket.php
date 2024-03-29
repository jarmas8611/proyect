<?php

namespace Taskeet\MainBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use FOS\CommentBundle\Entity\Thread as BaseThread;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="Taskeet\MainBundle\Entity\TicketRepository")
 */
class Ticket extends BaseThread
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=128)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="Media", mappedBy="ticket", cascade={"persist", "remove", "merge"}, orphanRemoval=true)
     */
    private $files;

    /**
     * @var array
     *
     * @ORM\ManyToOne(targetEntity="Priority")
     * @ORM\JoinColumn(name="priority_id", referencedColumnName="id")
     */
    private $priority;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime")
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="due_date", type="datetime")
     */
    private $dueDate;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tasks")
     */
    private $assignedTo;

    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="tickets")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    private $project;

    /**
     * @Gedmo\Slug(fields={"title", "id"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @var string $createdBy
     *
     * @Gedmo\Blameable(on="create")
     * @ORM\Column(type="string")
     */
    private $createdBy;

    /**
     * @var string $updatedBy
     *
     * @Gedmo\Blameable(on="update")
     * @ORM\Column(type="string")
     */
    private $updatedBy;

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
     * @ORM\ManyToOne(targetEntity="Status")
     */
    private $status;


    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $done;

    /**
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="followers",
     *      joinColumns={@ORM\JoinColumn(name="ticket_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     *      )
     **/
    private $followers;

    /**
     * @var datetime $reminder
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $reminder;

    /**
     * @ORM\ManyToOne(targetEntity="Department", inversedBy="tickets")
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id")
     */
    private $department;

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
     * @return Ticket
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
     * Set description
     *
     * @param string $description
     * @return Ticket
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
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Ticket
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set dueDate
     *
     * @param \DateTime $dueDate
     * @return Ticket
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * Get dueDate
     *
     * @return \DateTime
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }


    /**
     * Set slug
     *
     * @param string $slug
     * @return Ticket
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set createdBy
     *
     * @param string $createdBy
     * @return Ticket
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Ticket
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
     * @return Ticket
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
     * Set priority
     *
     * @param \Taskeet\MainBundle\Entity\Priority $priority
     * @return Ticket
     */
    public function setPriority(\Taskeet\MainBundle\Entity\Priority $priority = null)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return \Taskeet\MainBundle\Entity\Priority
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set assignedTo
     *
     * @param \Taskeet\MainBundle\Entity\User $assignedTo
     * @return Ticket
     */
    public function setAssignedTo(\Taskeet\MainBundle\Entity\User $assignedTo = null)
    {
        $this->assignedTo = $assignedTo;

        return $this;
    }

    /**
     * Get assignedTo
     *
     * @return \Taskeet\MainBundle\Entity\User
     */
    public function getAssignedTo()
    {
        return $this->assignedTo;
    }

    /**
     * Set project
     *
     * @param \Taskeet\MainBundle\Entity\Project $project
     * @return Ticket
     */
    public function setProject(\Taskeet\MainBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \Taskeet\MainBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set updatedBy
     *
     * @param string $updatedBy
     * @return Ticket
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return string
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Set done
     *
     * @param bool $done
     *
     * @return Ticket
     */
    public function setDone($done = false)
    {
        $this->done = $done;

        return $this;
    }

    /**
     * Get done
     *
     * @return bool
     */
    public function getDone()
    {
        return $this->done;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function __toString()
    {
        return $this->title;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setPermalink("");
        $this->startDate = new \DateTime("now");
        $this->files = new \Doctrine\Common\Collections\ArrayCollection();
        $this->followers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add files
     *
     * @param \Taskeet\MainBundle\Entity\Media $files
     * @return Ticket
     */
    public function addFile(\Taskeet\MainBundle\Entity\Media $files)
    {
        $this->files[] = $files;

        return $this;
    }

    /**
     * Remove files
     *
     * @param \Taskeet\MainBundle\Entity\Media $files
     */
    public function removeFile(\Taskeet\MainBundle\Entity\Media $files)
    {
        $this->files->removeElement($files);
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

    /**
     * Get User Department
     *
     * @return \Taskeet\MainBundle\Entity\Department
     */
    public function getUserDepartment()
    {
        return $this->getAssignedTo()->getDepartment();
    }

    /**
     * Add followers
     *
     * @param \Taskeet\MainBundle\Entity\User $followers
     * @return Ticket
     */
    public function addFollower(\Taskeet\MainBundle\Entity\User $followers)
    {
        $this->followers[] = $followers;

        return $this;
    }

    /**
     * Remove followers
     *
     * @param \Taskeet\MainBundle\Entity\User $followers
     */
    public function removeFollower(\Taskeet\MainBundle\Entity\User $followers)
    {
        $this->followers->removeElement($followers);
    }

    /**
     * Get followers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFollowers()
    {
        return $this->followers;
    }

    /**
     * Set reminder
     *
     * @param \DateTime $reminder
     * @return Ticket
     */
    public function setReminder($reminder)
    {
        $this->reminder = $reminder;

        return $this;
    }

    /**
     * Get reminder
     *
     * @return \DateTime 
     */
    public function getReminder()
    {
        return $this->reminder;
    }

    /**
     * Set department
     *
     * @param \Taskeet\MainBundle\Entity\Department $department
     * @return Ticket
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
