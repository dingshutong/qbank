<?php

namespace WB\QbankBundle\Entity;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Indicators
 *
 * @ExclusionPolicy("all") 
 */
class Indicators
{
    /**
     * @var integer
     * @Expose
     */
    private $id;

    /**
     * @var string
     */
    private $alternateId;

    /**
     * @var string
     * @Expose
     */
    private $name;

    /**
     * @var string
     * @Expose
     */
    private $description;

    /**
     * @var string
     * @Expose
     */
    private $dataSource;

    /**
     * @var string
     * @Expose
     */
    private $rationale;

    /**
     * @var string
     * @Expose
     */
    private $methodology;

    /**
     * @var string
     * @Expose
     */
    private $frequency;

    /**
     * @var string
     * @Expose
     */
    private $dissagregation;

    /**
     * @var string
     */
    private $limitation;

    /**
     * @var string
     */
    private $qualityControl;

    /**
     * @var string
     */
    private $methodImputation;

    /**
     * @var string
     */
    private $unitMeasurement;

    /**
     * @var string
     */
    private $methodProjection;

    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $versionDate;

    /**
     * @var string
     */
    private $notes;

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
    private $modified;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $indicatorAlias;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $indicatorGrpRef;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $indicatorCollRef;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $indicatorRelTerms;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @Expose
     */
    private $indicatorRelResources;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $indicatorRelModules;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $indicatorRelClassifications;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $indicatorRelCustodians;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->indicatorAlias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->indicatorGrpRef = new \Doctrine\Common\Collections\ArrayCollection();
        $this->indicatorCollRef = new \Doctrine\Common\Collections\ArrayCollection();
        $this->indicatorRelTerms = new \Doctrine\Common\Collections\ArrayCollection();
        $this->indicatorRelResources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->indicatorRelModules = new \Doctrine\Common\Collections\ArrayCollection();
        $this->indicatorRelClassifications = new \Doctrine\Common\Collections\ArrayCollection();
        $this->indicatorRelCustodians = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Indicators
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
     * @return Indicators
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
     * @return Indicators
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
     * Set dataSource
     *
     * @param string $dataSource
     *
     * @return Indicators
     */
    public function setDataSource($dataSource)
    {
        $this->dataSource = $dataSource;

        return $this;
    }

    /**
     * Get dataSource
     *
     * @return string
     */
    public function getDataSource()
    {
        return $this->dataSource;
    }

    /**
     * Set rationale
     *
     * @param string $rationale
     *
     * @return Indicators
     */
    public function setRationale($rationale)
    {
        $this->rationale = $rationale;

        return $this;
    }

    /**
     * Get rationale
     *
     * @return string
     */
    public function getRationale()
    {
        return $this->rationale;
    }

    /**
     * Set methodology
     *
     * @param string $methodology
     *
     * @return Indicators
     */
    public function setMethodology($methodology)
    {
        $this->methodology = $methodology;

        return $this;
    }

    /**
     * Get methodology
     *
     * @return string
     */
    public function getMethodology()
    {
        return $this->methodology;
    }

    /**
     * Set frequency
     *
     * @param string $frequency
     *
     * @return Indicators
     */
    public function setFrequency($frequency)
    {
        $this->frequency = $frequency;

        return $this;
    }

    /**
     * Get frequency
     *
     * @return string
     */
    public function getFrequency()
    {
        return $this->frequency;
    }

    /**
     * Set dissagregation
     *
     * @param string $dissagregation
     *
     * @return Indicators
     */
    public function setDissagregation($dissagregation)
    {
        $this->dissagregation = $dissagregation;

        return $this;
    }

    /**
     * Get dissagregation
     *
     * @return string
     */
    public function getDissagregation()
    {
        return $this->dissagregation;
    }

    /**
     * Set limitation
     *
     * @param string $limitation
     *
     * @return Indicators
     */
    public function setLimitation($limitation)
    {
        $this->limitation = $limitation;

        return $this;
    }

    /**
     * Get limitation
     *
     * @return string
     */
    public function getLimitation()
    {
        return $this->limitation;
    }

    /**
     * Set qualityControl
     *
     * @param string $qualityControl
     *
     * @return Indicators
     */
    public function setQualityControl($qualityControl)
    {
        $this->qualityControl = $qualityControl;

        return $this;
    }

    /**
     * Get qualityControl
     *
     * @return string
     */
    public function getQualityControl()
    {
        return $this->qualityControl;
    }

    /**
     * Set methodImputation
     *
     * @param string $methodImputation
     *
     * @return Indicators
     */
    public function setMethodImputation($methodImputation)
    {
        $this->methodImputation = $methodImputation;

        return $this;
    }

    /**
     * Get methodImputation
     *
     * @return string
     */
    public function getMethodImputation()
    {
        return $this->methodImputation;
    }

    /**
     * Set unitMeasurement
     *
     * @param string $unitMeasurement
     *
     * @return Indicators
     */
    public function setUnitMeasurement($unitMeasurement)
    {
        $this->unitMeasurement = $unitMeasurement;

        return $this;
    }

    /**
     * Get unitMeasurement
     *
     * @return string
     */
    public function getUnitMeasurement()
    {
        return $this->unitMeasurement;
    }

    /**
     * Set methodProjection
     *
     * @param string $methodProjection
     *
     * @return Indicators
     */
    public function setMethodProjection($methodProjection)
    {
        $this->methodProjection = $methodProjection;

        return $this;
    }

    /**
     * Get methodProjection
     *
     * @return string
     */
    public function getMethodProjection()
    {
        return $this->methodProjection;
    }

    /**
     * Set version
     *
     * @param string $version
     *
     * @return Indicators
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set versionDate
     *
     * @param string $versionDate
     *
     * @return Indicators
     */
    public function setVersionDate($versionDate)
    {
        $this->versionDate = $versionDate;

        return $this;
    }

    /**
     * Get versionDate
     *
     * @return string
     */
    public function getVersionDate()
    {
        return $this->versionDate;
    }

    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return Indicators
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Indicators
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
     * @return Indicators
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
     * Set modified
     *
     * @param \DateTime $modified
     *
     * @return Indicators
     */
    public function setModified($modified)
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * Get modified
     *
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Indicators
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
     * Add indicatorAlias
     *
     * @param \WB\QbankBundle\Entity\IndicatorAliases $indicatorAlias
     *
     * @return Indicators
     */
    public function addIndicatorAlias(\WB\QbankBundle\Entity\IndicatorAliases $indicatorAlias)
    {
        $this->indicatorAlias[] = $indicatorAlias;

        return $this;
    }

    /**
     * Remove indicatorAlias
     *
     * @param \WB\QbankBundle\Entity\IndicatorAliases $indicatorAlias
     */
    public function removeIndicatorAlias(\WB\QbankBundle\Entity\IndicatorAliases $indicatorAlias)
    {
        $this->indicatorAlias->removeElement($indicatorAlias);
    }

    /**
     * Get indicatorAlias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIndicatorAlias()
    {
        return $this->indicatorAlias;
    }

    /**
     * Add indicatorGrpRef
     *
     * @param \WB\QbankBundle\Entity\IndGrpRef $indicatorGrpRef
     *
     * @return Indicators
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

    /**
     * Add indicatorCollRef
     *
     * @param \WB\QbankBundle\Entity\IndCollectionRef $indicatorCollRef
     *
     * @return Indicators
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

    /**
     * Add indicatorRelTerms
     *
     * @param \WB\QbankBundle\Entity\IndicatorRelTerms $indicatorRelTerms
     *
     * @return Indicators
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
     * Add indicatorRelResources
     *
     * @param \WB\QbankBundle\Entity\IndicatorRelResources $indicatorRelResources
     *
     * @return Indicators
     */
    public function addIndicatorRelResource(\WB\QbankBundle\Entity\IndicatorRelResources $indicatorRelResources)
    {
        $this->indicatorRelResources[] = $indicatorRelResources;
    
        return $this;
    }

    /**
     * Remove indicatorRelResources
     *
     * @param \WB\QbankBundle\Entity\IndicatorRelResources $indicatorRelResources
     */
    public function removeIndicatorRelResource(\WB\QbankBundle\Entity\IndicatorRelResources $indicatorRelResources)
    {
        $this->indicatorRelResources->removeElement($indicatorRelResources);
    }

    /**
     * Get indicatorRelResources
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIndicatorRelResources()
    {
        return $this->indicatorRelResources;
    }

    /**
     * Add indicatorRelModules
     *
     * @param \WB\QbankBundle\Entity\IndicatorRelModules $indicatorRelModules
     *
     * @return Indicators
     */
    public function addIndicatorRelModule(\WB\QbankBundle\Entity\IndicatorRelModules $indicatorRelModules)
    {
        $this->indicatorRelModules[] = $indicatorRelModules;
    
        return $this;
    }

    /**
     * Remove indicatorRelModules
     *
     * @param \WB\QbankBundle\Entity\IndicatorRelModules $indicatorRelModules
     */
    public function removeIndicatorRelModule(\WB\QbankBundle\Entity\IndicatorRelModules $indicatorRelModules)
    {
        $this->indicatorRelModules->removeElement($indicatorRelModules);
    }

    /**
     * Get indicatorRelModules
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIndicatorRelModules()
    {
        return $this->indicatorRelModules;
    }

    /**
     * Add indicatorRelClassifications
     *
     * @param \WB\QbankBundle\Entity\IndicatorRelClassifications $indicatorRelClassifications
     *
     * @return Indicators
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
     * Add indicatorRelCustodians
     *
     * @param \WB\QbankBundle\Entity\IndicatorRelCustodians $indicatorRelCustodians
     *
     * @return Indicators
     */
    public function addIndicatorRelCustodian(\WB\QbankBundle\Entity\IndicatorRelCustodians $indicatorRelCustodians)
    {
        $this->indicatorRelCustodians[] = $indicatorRelCustodians;
    
        return $this;
    }

    /**
     * Remove indicatorRelCustodians
     *
     * @param \WB\QbankBundle\Entity\IndicatorRelCustodians $indicatorRelCustodians
     */
    public function removeIndicatorRelCustodian(\WB\QbankBundle\Entity\IndicatorRelCustodians $indicatorRelCustodians)
    {
        $this->indicatorRelCustodians->removeElement($indicatorRelCustodians);
    }

    /**
     * Get indicatorRelCustodians
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIndicatorRelCustodians()
    {
        return $this->indicatorRelCustodians;
    }
    
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     * @Expose
     */
    private $indicatorRelSources;


    /**
     * Add indicatorRelSources
     *
     * @param \WB\QbankBundle\Entity\IndicatorRelSources $indicatorRelSources
     * @return Indicators
     */
    public function addIndicatorRelSource(\WB\QbankBundle\Entity\IndicatorRelSources $indicatorRelSources)
    {
        $this->indicatorRelSources[] = $indicatorRelSources;

        return $this;
    }

    /**
     * Remove indicatorRelSources
     *
     * @param \WB\QbankBundle\Entity\IndicatorRelSources $indicatorRelSources
     */
    public function removeIndicatorRelSource(\WB\QbankBundle\Entity\IndicatorRelSources $indicatorRelSources)
    {
        $this->indicatorRelSources->removeElement($indicatorRelSources);
    }

    /**
     * Get indicatorRelSources
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIndicatorRelSources()
    {
        return $this->indicatorRelSources;
    }
}
