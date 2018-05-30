<?php

namespace WB\QbankBundle\Entity;

/**
 * IndicatorCollections
 */
class IndicatorCollections
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $alternateId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $pid;

    /**
     * @var integer
     */
    private $weight;

    /**
     * @var boolean
     */
    private $published;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $indicatorCollRef;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->indicatorCollRef = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set alternateId
     *
     * @param string $alternateId
     *
     * @return IndicatorCollections
     */
    public function setAlternateId($alternateId)
    {
        $this->alternateId = $alternateId;
    
        return $this;
    }

    /**
     * Get alternateId
     *
     * @return string
     */
    public function getAlternateId()
    {
        return $this->alternateId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return IndicatorCollections
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
     *
     * @return IndicatorCollections
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
     * Set pid
     *
     * @param integer $pid
     *
     * @return IndicatorCollections
     */
    public function setPid($pid)
    {
        $this->pid = $pid;
    
        return $this;
    }

    /**
     * Get pid
     *
     * @return integer
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     *
     * @return IndicatorCollections
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

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return IndicatorCollections
     */
    public function setPublished($published)
    {
        $this->published = $published;
    
        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Add indicatorCollRef
     *
     * @param \WB\QbankBundle\Entity\IndCollectionRef $indicatorCollRef
     *
     * @return IndicatorCollections
     */
    public function addIndicatorCollRef(\WB\QbankBundle\Entity\IndCollectionRef $indicatorCollRef)
    {
        $this->indicatorCollRef[] = $indicatorCollRef;
    
        return $this;
    }

    /**
     * Remove indicatorCollRef
     *
     * @param \WB\QbankBundle\Entity\IndCollectionRef $indicatorCollRef
     */
    public function removeIndicatorCollRef(\WB\QbankBundle\Entity\IndCollectionRef $indicatorCollRef)
    {
        $this->indicatorCollRef->removeElement($indicatorCollRef);
    }

    /**
     * Get indicatorCollRef
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIndicatorCollRef()
    {
        return $this->indicatorCollRef;
    }
}
