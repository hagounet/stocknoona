<?php

namespace Noona\StockBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Image
 *
 * @ORM\Entity(repositoryClass="Noona\StockBundle\Entity\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image

{
    /**
     *
     * @Assert\Image(mimeTypes={"image/jpeg","image/png","image/gif"})
     */
    private $file;

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
     * @ORM\Column(name="extension", type="string", length=255)
     */
    private $extension;

    /**
     * @var string
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;



    private $tempFilename;


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
     * Set extension
     *
     * @param string $extension
     * @return Image
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }


    /**
     * Get Extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        if($this->extension !== null)
        {
            $this->tempFilename = $this->extension;
        }
        $this->alt= null;
        $this->extension = null;
    }

    /**
     * @Assert\True(message="L'Image est obligatoire, aucune image enregistrée")
     */
    public function isImage()
    {
        return !($this->file == null && $this->extension == null);
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $tempname
     */
    public function setTempFilename($tempFilename)
    {
        $this->tempFilename = $tempFilename;
    }

    /**
     * @return mixed
     */
    public function getTempFilename()
    {
        return $this->tempFilename;
    }

    /**
     *  @ORM\PreUpdate()
     *  @ORM\PrePersist()
     *
     */
    public function preUpload()
    {
        if($this->file === null)
        {
            return;
        }
        $this->extension = $this->file->guessExtension();
        $this->alt = $this->file->getClientOriginalName();
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function  upload()
    {
        if($this->file === null)
        {
            return;
        }
        $this->file->move(
            $this->getUploadRootDir(),$this->id.'.'.$this->extension
        );
    }

    /**
     * @ORM\PreRemove()
     */


    public function preRemoveUpload()
    {
        $this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->extension;
    }
    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if(file_exists($this->tempFilename))
        {
            unlink($this->tempFilename);
        }
    }


    public function getUploadDir()
    {
        return 'uploads/img';
    }

    public function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getWebPath()
    {
        return $this->getUploadDir().'/'.$this->id.'.'.$this->extension;
    }

}
