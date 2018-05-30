<?php

namespace WB\QbankBundle\Entity;

/**
 * ClassificationGroups
 */
class ClassificationGroups
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
    private $classificationGrpRef;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->classificationGrpRef = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return ClassificationGroups
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
     * @return ClassificationGroups
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
     * @return ClassificationGroups
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
     * @return ClassificationGroups
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
     * @return ClassificationGroups
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
     * @return ClassificationGroups
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
     * Add classificationGrpRef
     *
     * @param \WB\QbankBundle\Entity\ClassificationGrpRef $classificationGrpRef
     *
     * @return ClassificationGroups
     */
    public function addClassificationGrpRef(\WB\QbankBundle\Entity\ClassificationGrpRef $classificationGrpRef)
    {
        $this->classificationGrpRef[] = $classificationGrpRef;
    
        return $this;
    }

    /**
     * Remove classificationGrpRef
     *
     * @param \WB\QbankBundle\Entity\ClassificationGrpRef $classificationGrpRef
     */
    public function removeClassificationGrpRef(\WB\QbankBundle\Entity\ClassificationGrpRef $classificationGrpRef)
    {
        $this->classificationGrpRef->removeElement($classificationGrpRef);
    }

    /**
     * Get classificationGrpRef
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClassificationGrpRef()
    {
        return $this->classificationGrpRef;
    }
}
