<?php

namespace WB\QbankBundle\Entity;

/**
 * Terms
 */
class Terms
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
    private $weight;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $termGrpRef;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $indicatorRelTerms;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $termRelResources;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $termRelCustodians;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $classificationRelTerms;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->termGrpRef = new \Doctrine\Common\Collections\ArrayCollection();
        $this->indicatorRelTerms = new \Doctrine\Common\Collections\ArrayCollection();
        $this->termRelResources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->termRelCustodians = new \Doctrine\Common\Collections\ArrayCollection();
        $this->classificationRelTerms = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Terms
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
     * @return Terms
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
     * @return Terms
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
     * Set weight
     *
     * @param integer $weight
     *
     * @return Terms
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
     * Add termGrpRef
     *
     * @param \WB\QbankBundle\Entity\TermGrpRef $termGrpRef
     *
     * @return Terms
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

    /**
     * Add indicatorRelTerms
     *
     * @param \WB\QbankBundle\Entity\IndicatorRelTerms $indicatorRelTerms
     *
     * @return Terms
     */
    public function addIndicatorRelTerm(\WB\QbankBundle\Entity\IndicatorRelTerms $indicatorRelTerms)
    {
        $this->indicatorRelTerms[] = $indicatorRelTerms;
    
        return $this;
    }

    /**
     * Remove indicatorRelTerms
     *
     * @param \WB\QbankBundle\Entity\IndicatorRelTerms $indicatorRelTerms
     */
    public function removeIndicatorRelTerm(\WB\QbankBundle\Entity\IndicatorRelTerms $indicatorRelTerms)
    {
        $this->indicatorRelTerms->removeElement($indicatorRelTerms);
    }

    /**
     * Get indicatorRelTerms
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIndicatorRelTerms()
    {
        return $this->indicatorRelTerms;
    }

    /**
     * Add termRelResources
     *
     * @param \WB\QbankBundle\Entity\TermRelResources $termRelResources
     *
     * @return Terms
     */
    public function addTermRelResource(\WB\QbankBundle\Entity\TermRelResources $termRelResources)
    {
        $this->termRelResources[] = $termRelResources;
    
        return $this;
    }

    /**
     * Remove termRelResources
     *
     * @param \WB\QbankBundle\Entity\TermRelResources $termRelResources
     */
    public function removeTermRelResource(\WB\QbankBundle\Entity\TermRelResources $termRelResources)
    {
        $this->termRelResources->removeElement($termRelResources);
    }

    /**
     * Get termRelResources
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTermRelResources()
    {
        return $this->termRelResources;
    }

    /**
     * Add termRelCustodians
     *
     * @param \WB\QbankBundle\Entity\TermRelCustodians $termRelCustodians
     *
     * @return Terms
     */
    public function addTermRelCustodian(\WB\QbankBundle\Entity\TermRelCustodians $termRelCustodians)
    {
        $this->termRelCustodians[] = $termRelCustodians;
    
        return $this;
    }

    /**
     * Remove termRelCustodians
     *
     * @param \WB\QbankBundle\Entity\TermRelCustodians $termRelCustodians
     */
    public function removeTermRelCustodian(\WB\QbankBundle\Entity\TermRelCustodians $termRelCustodians)
    {
        $this->termRelCustodians->removeElement($termRelCustodians);
    }

    /**
     * Get termRelCustodians
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTermRelCustodians()
    {
        return $this->termRelCustodians;
    }

    /**
     * Add classificationRelTerms
     *
     * @param \WB\QbankBundle\Entity\ClassificationRelTerms $classificationRelTerms
     *
     * @return Terms
     */
    public function addClassificationRelTerm(\WB\QbankBundle\Entity\ClassificationRelTerms $classificationRelTerms)
    {
        $this->classificationRelTerms[] = $classificationRelTerms;
    
        return $this;
    }

    /**
     * Remove classificationRelTerms
     *
     * @param \WB\QbankBundle\Entity\ClassificationRelTerms $classificationRelTerms
     */
    public function removeClassificationRelTerm(\WB\QbankBundle\Entity\ClassificationRelTerms $classificationRelTerms)
    {
        $this->classificationRelTerms->removeElement($classificationRelTerms);
    }

    /**
     * Get classificationRelTerms
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClassificationRelTerms()
    {
        return $this->classificationRelTerms;
    }
    /**
     * @var boolean
     */
    private $published;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $changed;


    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Terms
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Terms
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
     * Set changed
     *
     * @param \DateTime $changed
     *
     * @return Terms
     */
    public function setChanged($changed)
    {
        $this->changed = $changed;
    
        return $this;
    }

    /**
     * Get changed
     *
     * @return \DateTime
     */
    public function getChanged()
    {
        return $this->changed;
    }
    /**
     * @var string
     */
    private $notes;


    /**
     * Set notes.
    
     *
     * @param string $notes
     *
     * @return Terms
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    
        return $this;
    }

    /**
     * Get notes.
    
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $termRelSources;


    /**
     * Add termRelSources
     *
     * @param \WB\QbankBundle\Entity\TermRelSources $termRelSources
     * @return Terms
     */
    public function addTermRelSource(\WB\QbankBundle\Entity\TermRelSources $termRelSources)
    {
        $this->termRelSources[] = $termRelSources;

        return $this;
    }

    /**
     * Remove termRelSources
     *
     * @param \WB\QbankBundle\Entity\TermRelSources $termRelSources
     */
    public function removeTermRelSource(\WB\QbankBundle\Entity\TermRelSources $termRelSources)
    {
        $this->termRelSources->removeElement($termRelSources);
    }

    /**
     * Get termRelSources
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTermRelSources()
    {
        return $this->termRelSources;
    }
}
