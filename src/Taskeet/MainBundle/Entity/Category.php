<?php

namespace Taskeet\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
//use Symfony\Component\HttpFoundation\File\File;
//use Symfony\Component\Validator\Constraints as Assert;
//use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity
 */
class Category
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
//    /**
//     * @Assert\File(
//     *     maxSize="1M",
//     *     mimeTypes={"image/png", "image/jpeg", "image/pjpeg"}
//     * )
//     * @Vich\UploadableField(mapping="category_image", fileNameProperty="name")
//     *
//     * @var File $image
//     */
//    protected $image;

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
     * @return Category
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

    public function __toString()
    {
        return $this->name;
    }
}
