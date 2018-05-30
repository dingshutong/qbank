<?php

namespace WB\QbankBundle\Entity;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;


/**
 * Resources
 * @ExclusionPolicy("all") 
 */
class Resources
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
    private $description;

    /**
     * @var string
     * @Expose
     */
    private $title;

    /**
     * @var string
     */
    private $subtitle;

    /**
     * @var string
     */
    private $creator;

    /**
     * @var string
     */
    private $alternateTitle;

    /**
     * @var string
     * @Expose
     */
    private $publisher;

    /**
     * @var string
     */
    private $contributor;

    /**
     * @var string
     */
    private $pubDate;

    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $intIdentifier;

    /**
     * @var string
     */
    private $copyright;

    /**
     * @var string
     * @Expose
     */
    private $url;

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
     * @var \WB\QbankBundle\Entity\DocTypes
     */
    private $docType;
    /**
     * @var string
     */
    private $filename;
    /**
     * @var string
     */
    private $filesize;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $classificationRelResources;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $indicatorRelResources;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $termRelResources;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $questionnaireGroupRelResources;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $questionnaireModuleRelResources;

    /**
     * @var int
     */
    private $dateAccessed;

    /**
     * Get dateAccessed
     *
     * @return int
     */
    public function getDateAccessed()
    {
        return $this->dateAccessed;
    }

    /**
     * @param int $dateAccessed
     */
    public function setDateAccessed($dateAccessed)
    {
        $this->dateAccessed = $dateAccessed;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->classificationRelResources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->indicatorRelResources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->termRelResources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->questionnaireGroupRelResources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->questionnaireModuleRelResources = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Resources
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
     * Set description
     *
     * @param string $description
     *
     * @return Resources
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
     * Set title
     *
     * @param string $title
     *
     * @return Resources
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
     * Set subtitle
     *
     * @param string $subtitle
     *
     * @return Resources
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    /**
     * Get subtitle
     *
     * @return string
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set creator
     *
     * @param string $creator
     *
     * @return Resources
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return string
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Set alternateTitle
     *
     * @param string $alternateTitle
     *
     * @return Resources
     */
    public function setAlternateTitle($alternateTitle)
    {
        $this->alternateTitle = $alternateTitle;

        return $this;
    }

    /**
     * Get alternateTitle
     *
     * @return string
     */
    public function getAlternateTitle()
    {
        return $this->alternateTitle;
    }

    /**
     * Set publisher
     *
     * @param string $publisher
     *
     * @return Resources
     */
    public function setPublisher($publisher)
    {
        $this->publisher = $publisher;

        return $this;
    }

    /**
     * Get publisher
     *
     * @return string
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * Set contributor
     *
     * @param string $contributor
     *
     * @return Resources
     */
    public function setContributor($contributor)
    {
        $this->contributor = $contributor;

        return $this;
    }

    /**
     * Get contributor
     *
     * @return string
     */
    public function getContributor()
    {
        return $this->contributor;
    }

    /**
     * Set pubDate
     *
     * @param string $pubDate
     *
     * @return Resources
     */
    public function setPubDate($pubDate)
    {
        $this->pubDate = $pubDate;

        return $this;
    }

    /**
     * Get pubDate
     *
     * @return string
     */
    public function getPubDate()
    {
        return $this->pubDate;
    }

    /**
     * Set language
     *
     * @param string $language
     *
     * @return Resources
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set intIdentifier
     *
     * @param string $intIdentifier
     *
     * @return Resources
     */
    public function setIntIdentifier($intIdentifier)
    {
        $this->intIdentifier = $intIdentifier;

        return $this;
    }

    /**
     * Get intIdentifier
     *
     * @return string
     */
    public function getIntIdentifier()
    {
        return $this->intIdentifier;
    }

    /**
     * Set copyright
     *
     * @param string $copyright
     *
     * @return Resources
     */
    public function setCopyright($copyright)
    {
        $this->copyright = $copyright;

        return $this;
    }

    /**
     * Get copyright
     *
     * @return string
     */
    public function getCopyright()
    {
        return $this->copyright;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Resources
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Resources
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
     * @return Resources
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
     * @return Resources
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
     * Set docType
     *
     * @param \WB\QbankBundle\Entity\DocTypes $docType
     *
     * @return Resources
     */
    public function setDocType($docType)
    {
        $this->docType = $docType;

        return $this;
    }

    /**
     * Get docType
     *
     * @return \WB\QbankBundle\Entity\DocTypes
     */
    public function getDocType()
    {
        return $this->docType;
    }

    /**
     * Set filename
     *
     * @param string $filename
     *
     * @return Resources
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set filesize
     *
     * @param string $filesize
     *
     * @return Resources
     */
    public function setFilesize($filesize)
    {
        $this->filesize = $filesize;

        return $this;
    }

    /**
     * Get filesize
     *
     * @return string
     */
    public function getFilesize()
    {
        return $this->filesize;
    }

    /**
     * Add classificationRelResources
     *
     * @param \WB\QbankBundle\Entity\ClassificationRelResources $classificationRelResources
     *
     * @return Resources
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
     * Add indicatorRelResources
     *
     * @param \WB\QbankBundle\Entity\IndicatorRelResources $indicatorRelResources
     *
     * @return Resources
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
     * Add termRelResources
     *
     * @param \WB\QbankBundle\Entity\TermRelResources $termRelResources
     *
     * @return Resources
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
     * Add questionnaireGroupRelResources
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireGroupRelResources $questionnaireGroupRelResources
     *
     * @return Resources
     */
    public function addQuestionnaireGroupRelResource(\WB\QbankBundle\Entity\QuestionnaireGroupRelResources $questionnaireGroupRelResources)
    {
        $this->questionnaireGroupRelResources[] = $questionnaireGroupRelResources;

        return $this;
    }

    /**
     * Remove questionnaireGroupRelResources
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireGroupRelResources $questionnaireGroupRelResources
     */
    public function removeQuestionnaireGroupRelResource(\WB\QbankBundle\Entity\QuestionnaireGroupRelResources $questionnaireGroupRelResources)
    {
        $this->questionnaireGroupRelResources->removeElement($questionnaireGroupRelResources);
    }

    /**
     * Get questionnaireGroupRelResources
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestionnaireGroupRelResources()
    {
        return $this->questionnaireGroupRelResources;
    }

    /**
     * Add questionnaireModuleRelResources
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireModulesRelResources $questionnaireModuleRelResources
     *
     * @return Resources
     */
    public function addQuestionnaireModuleRelResource(\WB\QbankBundle\Entity\QuestionnaireModulesRelResources $questionnaireModuleRelResources)
    {
        $this->questionnaireModuleRelResources[] = $questionnaireModuleRelResources;

        return $this;
    }

    /**
     * Remove questionnaireModuleRelResources
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireModulesRelResources $questionnaireModuleRelResources
     */
    public function removeQuestionnaireModuleRelResource(\WB\QbankBundle\Entity\QuestionnaireModulesRelResources $questionnaireModuleRelResources)
    {
        $this->questionnaireModuleRelResources->removeElement($questionnaireModuleRelResources);
    }

    /**
     * Get questionnaireModuleRelResources
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestionnaireModuleRelResources()
    {
        return $this->questionnaireModuleRelResources;
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $indicatorRelSources;


    /**
     * Add indicatorRelSources
     *
     * @param \WB\QbankBundle\Entity\IndicatorRelSources $indicatorRelSources
     * @return Resources
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
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $termRelSources;


    /**
     * Add termRelSources
     *
     * @param \WB\QbankBundle\Entity\TermRelSources $termRelSources
     * @return Resources
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
