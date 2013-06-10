<?php

namespace Taskeet\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;

use Admingenerator\GeneratorBundle\Model\FileInterface;

/**
 * Media
 *
 * @ORM\Entity
 * @ORM\Table(name="media")
 * @Vich\Uploadable
 */
class Media implements FileInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @Vich\UploadableField(mapping="ticket_file", fileNameProperty="path")
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @ORM\ManyToOne(targetEntity="Ticket", inversedBy="files", cascade={"all"})
     * @ORM\JoinColumn(name="ticket_id", referencedColumnName="id")
     */
    private $ticket;

    /**
     * @var integer
     *
     * @ORM\Column(name="position", type="integer", nullable=true)
     */
    private $position;


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
     * @return Media
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
     * @return Media
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
     * Set path
     *
     * @param string $path
     * @return Media
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Media
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set file
     *
     * @param Symfony\Component\HttpFoundation\File\File $file
     * @return Media
     */
    public function setFile(\Symfony\Component\HttpFoundation\File\File $file)
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

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->file->getFileInfo()->getSize();
    }

    /**
     * @inheritDoc
     */
    public function setParent($parent) {
        $this->setTicket($parent);
    }

    /**
     * @inheritDoc
     */
    public function getPreview()
    {
        // return (preg_match('/image\/.*/i', $this->getMimeType()));
        return false;
    }

    /**
     * Set ticket
     *
     * @param \Taskeet\MainBundle\Entity\Ticket $ticket
     * @return Media
     */
    public function setTicket(\Taskeet\MainBundle\Entity\Ticket $ticket = null)
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * Get ticket
     *
     * @return \Taskeet\MainBundle\Entity\Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
