<?php

namespace WB\QbankBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocTypes
 */
class DocTypes
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $resources;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->resources = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return DocTypes
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
     * Add resources
     *
     * @param \WB\QbankBundle\Entity\Resources $resources
     *
     * @return DocTypes
     */
    public function addResource(\WB\QbankBundle\Entity\Resources $resources)
    {
        $this->resources[] = $resources;

        return $this;
    }

    /**
     * Remove resources
     *
     * @param \WB\QbankBundle\Entity\Resources $resources
     */
    public function removeResource(\WB\QbankBundle\Entity\Resources $resources)
    {
        $this->resources->removeElement($resources);
    }

    /**
     * Get resources
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResources()
    {
        return $this->resources;
    }

}
