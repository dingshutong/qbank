<?php

namespace WB\QbankBundle\Entity;

/**
 * TermGroups
 */
class TermGroups
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
    private $termGrpRef;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->termGrpRef = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return TermGroups
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
     * @return TermGroups
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
     * @return TermGroups
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
     * @return TermGroups
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
     * @return TermGroups
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
     * @return TermGroups
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
     * Add termGrpRef
     *
     * @param \WB\QbankBundle\Entity\TermGrpRef $termGrpRef
     *
     * @return TermGroups
     */
    public function addTermGrpRef(\WB\QbankBundle\Entity\TermGrpRef $termGrpRef)
    {
        $this->termGrpRef[] = $termGrpRef;
    
        return $this;
    }

    /**
     * Remove termGrpRef
     *
     * @param \WB\QbankBundle\Entity\TermGrpRef $termGrpRef
     */
    public function removeTermGrpRef(\WB\QbankBundle\Entity\TermGrpRef $termGrpRef)
    {
        $this->termGrpRef->removeElement($termGrpRef);
    }

    /**
     * Get termGrpRef
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTermGrpRef()
    {
        return $this->termGrpRef;
    }
}
