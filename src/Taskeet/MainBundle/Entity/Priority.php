<?php

namespace Taskeet\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Priority
 *
 * @ORM\Table(name="priority")
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Priority
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
     * @ORM\Column(name="name", type="string", length=16)
     */
    private $name;

    /**
     * @Assert\File(
     *     maxSize="1M",
     *     mimeTypes={"image/png", "image/jpeg", "image/pjpeg"}
     * )
     * @Vich\UploadableField(mapping="priority_image", fileNameProperty="imageName")
     *
     * @var File $image
     */
    private $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="weight", type="smallint")
     */
    private $weight;

    /**
     * @param \Symfony\Component\HttpFoundation\File\File $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\File\File
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @ORM\Column(type="string", length=255, name="image_name", nullable=true)
     *
     * @var string $imageName
     */
    protected $imageName;


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
     * @return Priority
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
     * Set imageName
     *
     * @param string $imageName
     * @return Status
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     * @return Priority
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer 
     */
    public function getWeight()
    {
        return $this->weight;
    }
}
