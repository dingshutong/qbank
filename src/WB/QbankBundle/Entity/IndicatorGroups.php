<?php

namespace WB\QbankBundle\Entity;

/**
 * IndicatorGroups
 */
class IndicatorGroups
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
    private $indicatorGrpRef;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->indicatorGrpRef = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return IndicatorGroups
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
     * @return IndicatorGroups
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
     * @return IndicatorGroups
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
     * @return IndicatorGroups
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
     * @return IndicatorGroups
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
     * @return IndicatorGroups
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
     * Add indicatorGrpRef
     *
     * @param \WB\QbankBundle\Entity\IndGrpRef $indicatorGrpRef
     *
     * @return IndicatorGroups
     */
    public function addIndicatorGrpRef(\WB\QbankBundle\Entity\IndGrpRef $indicatorGrpRef)
    {
        $this->indicatorGrpRef[] = $indicatorGrpRef;

        return $this;
    }

    /**
     * Remove indicatorGrpRef
     *
     * @param \WB\QbankBundle\Entity\IndGrpRef $indicatorGrpRef
     */
    public function removeIndicatorGrpRef(\WB\QbankBundle\Entity\IndGrpRef $indicatorGrpRef)
    {
        $this->indicatorGrpRef->removeElement($indicatorGrpRef);
    }

    /**
     * Get indicatorGrpRef
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIndicatorGrpRef()
    {
        return $this->indicatorGrpRef;
    }
}
