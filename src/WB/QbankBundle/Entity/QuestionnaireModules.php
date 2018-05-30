<?php

namespace WB\QbankBundle\Entity;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;


/**
 * QuestionnaireModules
 * 
 * @ExclusionPolicy("all") 
 */
class QuestionnaireModules
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
    private $qualityControl;

    /**
     * @var string
     * @Expose
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
     * @Expose
     */
    private $created;

    /**
     * @var \DateTime
     * @Expose
     */
    private $changed;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $indicatorRelModules;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $questionnaireGroupRelModules;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @Expose
     */
    private $resourcesRelModules;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @Expose
     */
    private $questionnaireModuleQuestions;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @Expose
     */
    private $questionnaireModuleResources;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->indicatorRelModules = new \Doctrine\Common\Collections\ArrayCollection();
        $this->questionnaireGroupRelModules = new \Doctrine\Common\Collections\ArrayCollection();
        $this->resourcesRelModules = new \Doctrine\Common\Collections\ArrayCollection();
        $this->questionnaireModuleQuestions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->questionnaireModuleResources = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return QuestionnaireModules
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
     * @return QuestionnaireModules
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
     * @return QuestionnaireModules
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
     * Set qualityControl
     *
     * @param string $qualityControl
     *
     * @return QuestionnaireModules
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
     * Set notes
     *
     * @param string $notes
     *
     * @return QuestionnaireModules
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
     * @return QuestionnaireModules
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
     * @return QuestionnaireModules
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
     * @return QuestionnaireModules
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
     * @return QuestionnaireModules
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
     * Add indicatorRelModules
     *
     * @param \WB\QbankBundle\Entity\IndicatorRelModules $indicatorRelModules
     *
     * @return QuestionnaireModules
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
     * Add questionnaireGroupRelModules
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireGroupRelModules $questionnaireGroupRelModules
     *
     * @return QuestionnaireModules
     */
    public function addQuestionnaireGroupRelModule(\WB\QbankBundle\Entity\QuestionnaireGroupRelModules $questionnaireGroupRelModules)
    {
        $this->questionnaireGroupRelModules[] = $questionnaireGroupRelModules;

        return $this;
    }

    /**
     * Remove questionnaireGroupRelModules
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireGroupRelModules $questionnaireGroupRelModules
     */
    public function removeQuestionnaireGroupRelModule(\WB\QbankBundle\Entity\QuestionnaireGroupRelModules $questionnaireGroupRelModules)
    {
        $this->questionnaireGroupRelModules->removeElement($questionnaireGroupRelModules);
    }

    /**
     * Get questionnaireGroupRelModules
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestionnaireGroupRelModules()
    {
        return $this->questionnaireGroupRelModules;
    }

    /**
     * Add questionnaireModuleQuestions
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireModuleQuestions $questionnaireModuleQuestions
     *
     * @return QuestionnaireModules
     */
    public function addQuestionnaireModuleQuestion(\WB\QbankBundle\Entity\QuestionnaireModuleQuestions $questionnaireModuleQuestions)
    {
        $this->questionnaireModuleQuestions[] = $questionnaireModuleQuestions;

        return $this;
    }

    /**
     * Remove questionnaireModuleQuestions
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireModuleQuestions $questionnaireModuleQuestions
     */
    public function removeQuestionnaireModuleQuestion(\WB\QbankBundle\Entity\QuestionnaireModuleQuestions $questionnaireModuleQuestions)
    {
        $this->questionnaireModuleQuestions->removeElement($questionnaireModuleQuestions);
    }

    /**
     * Get questionnaireModuleQuestions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestionnaireModuleQuestions()
    {
        return $this->questionnaireModuleQuestions;
    }

    /**
     * Add questionnaireModuleResources
     *
     * @param \WB\QbankBundle\Entity\Resources $questionnaireModuleResources
     *
     * @return QuestionnaireModules
     */
    public function addQuestionnaireModuleResource(\WB\QbankBundle\Entity\Resources $questionnaireModuleResources)
    {
        $this->questionnaireModuleResources[] = $questionnaireModuleResources;

        return $this;
    }

    /**
     * Remove questionnaireModuleResources
     *
     * @param \WB\QbankBundle\Entity\Resources $questionnaireModuleResources
     */
    public function removeQuestionnaireModuleResource(\WB\QbankBundle\Entity\Resources $questionnaireModuleResources)
    {
        $this->questionnaireModuleResources->removeElement($questionnaireModuleResources);
    }

    /**
     * Get questionnaireModuleResources
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestionnaireModuleResources()
    {
        return $this->questionnaireModuleResources;
    }


    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $sourcesRelModules;


    /**
     * Add resourcesRelModules
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireModulesRelResources $resourcesRelModules
     * @return QuestionnaireModules
     */
    public function addResourcesRelModule(\WB\QbankBundle\Entity\QuestionnaireModulesRelResources $resourcesRelModules)
    {
        $this->resourcesRelModules[] = $resourcesRelModules;

        return $this;
    }

    /**
     * Remove resourcesRelModules
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireModulesRelResources $resourcesRelModules
     */
    public function removeResourcesRelModule(\WB\QbankBundle\Entity\QuestionnaireModulesRelResources $resourcesRelModules)
    {
        $this->resourcesRelModules->removeElement($resourcesRelModules);
    }

    /**
     * Get resourcesRelModules
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getResourcesRelModules()
    {
        return $this->resourcesRelModules;
    }

    /**
     * Add sourcesRelModules
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireModulesRelSources $sourcesRelModules
     * @return QuestionnaireModules
     */
    public function addSourcesRelModule(\WB\QbankBundle\Entity\QuestionnaireModulesRelSources $sourcesRelModules)
    {
        $this->sourcesRelModules[] = $sourcesRelModules;

        return $this;
    }

    /**
     * Remove sourcesRelModules
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireModulesRelSources $sourcesRelModules
     */
    public function removeSourcesRelModule(\WB\QbankBundle\Entity\QuestionnaireModulesRelSources $sourcesRelModules)
    {
        $this->sourcesRelModules->removeElement($sourcesRelModules);
    }

    /**
     * Get sourcesRelModules
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSourcesRelModules()
    {
        return $this->sourcesRelModules;
    }
}
