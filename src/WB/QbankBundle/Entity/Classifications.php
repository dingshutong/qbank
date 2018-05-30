<?php

namespace WB\QbankBundle\Entity;

/**
 * Classifications
 */
class Classifications
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
     * @var string
     */
    private $valRepFormat;

    /**
     * @var string
     */
    private $vrfSyntax;

    /**
     * @var boolean
     */
    private $published;

    /**
     * @var integer
     */
    private $weight;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $changed;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $classificationCodes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $classificationGrpRef;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $indicatorRelClassifications;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $classificationRelResources;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $classificationRelCustodians;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $classificationRelTerms;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->classificationCodes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->classificationGrpRef = new \Doctrine\Common\Collections\ArrayCollection();
        $this->indicatorRelClassifications = new \Doctrine\Common\Collections\ArrayCollection();
        $this->classificationRelResources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->classificationRelCustodians = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Classifications
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
     * @return Classifications
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
     * @return Classifications
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
     * Set valRepFormat
     *
     * @param string $valRepFormat
     *
     * @return Classifications
     */
    public function setValRepFormat($valRepFormat)
    {
        $this->valRepFormat = $valRepFormat;
    
        return $this;
    }

    /**
     * Get valRepFormat
     *
     * @return string
     */
    public function getValRepFormat()
    {
        return $this->valRepFormat;
    }

    /**
     * Set vrfSyntax
     *
     * @param string $vrfSyntax
     *
     * @return Classifications
     */
    public function setVrfSyntax($vrfSyntax)
    {
        $this->vrfSyntax = $vrfSyntax;
    
        return $this;
    }

    /**
     * Get vrfSyntax
     *
     * @return string
     */
    public function getVrfSyntax()
    {
        return $this->vrfSyntax;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Classifications
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
     * Set weight
     *
     * @param integer $weight
     *
     * @return Classifications
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
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Classifications
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
     * @return Classifications
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
     * Add classificationCodes
     *
     * @param \WB\QbankBundle\Entity\ClassificationCodes $classificationCodes
     *
     * @return Classifications
     */
    public function addClassificationCode(\WB\QbankBundle\Entity\ClassificationCodes $classificationCodes)
    {
        $this->classificationCodes[] = $classificationCodes;
    
        return $this;
    }

    /**
     * Remove classificationCodes
     *
     * @param \WB\QbankBundle\Entity\ClassificationCodes $classificationCodes
     */
    public function removeClassificationCode(\WB\QbankBundle\Entity\ClassificationCodes $classificationCodes)
    {
        $this->classificationCodes->removeElement($classificationCodes);
    }

    /**
     * Get classificationCodes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClassificationCodes()
    {
        return $this->classificationCodes;
    }

    /**
     * Add classificationGrpRef
     *
     * @param \WB\QbankBundle\Entity\ClassificationGrpRef $classificationGrpRef
     *
     * @return Classifications
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

    /**
     * Add indicatorRelClassifications
     *
     * @param \WB\QbankBundle\Entity\IndicatorRelClassifications $indicatorRelClassifications
     *
     * @return Classifications
     */
    public function addIndicatorRelClassification(\WB\QbankBundle\Entity\IndicatorRelClassifications $indicatorRelClassifications)
    {
        $this->indicatorRelClassifications[] = $indicatorRelClassifications;
    
        return $this;
    }

    /**
     * Remove indicatorRelClassifications
     *
     * @param \WB\QbankBundle\Entity\IndicatorRelClassifications $indicatorRelClassifications
     */
    public function removeIndicatorRelClassification(\WB\QbankBundle\Entity\IndicatorRelClassifications $indicatorRelClassifications)
    {
        $this->indicatorRelClassifications->removeElement($indicatorRelClassifications);
    }

    /**
     * Get indicatorRelClassifications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIndicatorRelClassifications()
    {
        return $this->indicatorRelClassifications;
    }

    /**
     * Add classificationRelResources
     *
     * @param \WB\QbankBundle\Entity\ClassificationRelResources $classificationRelResources
     *
     * @return Classifications
     */
    public function addClassificationRelResource(\WB\QbankBundle\Entity\ClassificationRelResources $classificationRelResources)
    {
        $this->classificationRelResources[] = $classificationRelResources;
    
        return $this;
    }

    /**
     * Remove classificationRelResources
     *
     * @param \WB\QbankBundle\Entity\ClassificationRelResources $classificationRelResources
     */
    public function removeClassificationRelResource(\WB\QbankBundle\Entity\ClassificationRelResources $classificationRelResources)
    {
        $this->classificationRelResources->removeElement($classificationRelResources);
    }

    /**
     * Get classificationRelResources
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClassificationRelResources()
    {
        return $this->classificationRelResources;
    }

    /**
     * Add classificationRelCustodians
     *
     * @param \WB\QbankBundle\Entity\ClassificationRelCustodians $classificationRelCustodians
     *
     * @return Classifications
     */
    public function addClassificationRelCustodian(\WB\QbankBundle\Entity\ClassificationRelCustodians $classificationRelCustodians)
    {
        $this->classificationRelCustodians[] = $classificationRelCustodians;
    
        return $this;
    }

    /**
     * Remove classificationRelCustodians
     *
     * @param \WB\QbankBundle\Entity\ClassificationRelCustodians $classificationRelCustodians
     */
    public function removeClassificationRelCustodian(\WB\QbankBundle\Entity\ClassificationRelCustodians $classificationRelCustodians)
    {
        $this->classificationRelCustodians->removeElement($classificationRelCustodians);
    }

    /**
     * Get classificationRelCustodians
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClassificationRelCustodians()
    {
        return $this->classificationRelCustodians;
    }

    /**
     * Add classificationRelTerms
     *
     * @param \WB\QbankBundle\Entity\ClassificationRelTerms $classificationRelTerms
     *
     * @return Classifications
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $questionClassifications;


    /**
     * Add questionClassification
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireModuleQuestions $questionClassification
     *
     * @return Classifications
     */
    public function addQuestionClassification(\WB\QbankBundle\Entity\QuestionnaireModuleQuestions $questionClassification)
    {
        $this->questionClassifications[] = $questionClassification;
    
        return $this;
    }

    /**
     * Remove questionClassification
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireModuleQuestions $questionClassification
     */
    public function removeQuestionClassification(\WB\QbankBundle\Entity\QuestionnaireModuleQuestions $questionClassification)
    {
        $this->questionClassifications->removeElement($questionClassification);
    }

    /**
     * Get questionClassifications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestionClassifications()
    {
        return $this->questionClassifications;
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
     * @return Classifications
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
    private $classificationRelSources;


    /**
     * Add classificationRelSources
     *
     * @param \WB\QbankBundle\Entity\ClassificationRelSources $classificationRelSources
     * @return Classifications
     */
    public function addClassificationRelSource(\WB\QbankBundle\Entity\ClassificationRelSources $classificationRelSources)
    {
        $this->classificationRelSources[] = $classificationRelSources;

        return $this;
    }

    /**
     * Remove classificationRelSources
     *
     * @param \WB\QbankBundle\Entity\ClassificationRelSources $classificationRelSources
     */
    public function removeClassificationRelSource(\WB\QbankBundle\Entity\ClassificationRelSources $classificationRelSources)
    {
        $this->classificationRelSources->removeElement($classificationRelSources);
    }

    /**
     * Get classificationRelSources
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClassificationRelSources()
    {
        return $this->classificationRelSources;
    }
}
