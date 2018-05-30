<?php

namespace WB\QbankBundle\Entity;

/**
 * QuestionnaireGroups
 */
class QuestionnaireGroups
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
     * @var integer
     */
    private $pid;

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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $questionnaireGroupRelModules;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $questionnaireGroupRelResources;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $questionnaireGroupRelCustodians;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->questionnaireGroupRelModules = new \Doctrine\Common\Collections\ArrayCollection();
        $this->questionnaireGroupRelResources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->questionnaireGroupRelCustodians = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return QuestionnaireGroups
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
     * Set pid
     *
     * @param integer $pid
     *
     * @return QuestionnaireGroups
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
     * Set name
     *
     * @param string $name
     *
     * @return QuestionnaireGroups
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
     * @return QuestionnaireGroups
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
     * Set notes
     *
     * @param string $notes
     *
     * @return QuestionnaireGroups
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
     * @return QuestionnaireGroups
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
     * @return QuestionnaireGroups
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
     * Add questionnaireGroupRelModules
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireGroupRelModules $questionnaireGroupRelModules
     *
     * @return QuestionnaireGroups
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
     * Add questionnaireGroupRelResources
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireGroupRelResources $questionnaireGroupRelResources
     *
     * @return QuestionnaireGroups
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
     * Add questionnaireGroupRelCustodians
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireGroupRelCustodians $questionnaireGroupRelCustodians
     *
     * @return QuestionnaireGroups
     */
    public function addQuestionnaireGroupRelCustodian(\WB\QbankBundle\Entity\QuestionnaireGroupRelCustodians $questionnaireGroupRelCustodians)
    {
        $this->questionnaireGroupRelCustodians[] = $questionnaireGroupRelCustodians;
    
        return $this;
    }

    /**
     * Remove questionnaireGroupRelCustodians
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireGroupRelCustodians $questionnaireGroupRelCustodians
     */
    public function removeQuestionnaireGroupRelCustodian(\WB\QbankBundle\Entity\QuestionnaireGroupRelCustodians $questionnaireGroupRelCustodians)
    {
        $this->questionnaireGroupRelCustodians->removeElement($questionnaireGroupRelCustodians);
    }

    /**
     * Get questionnaireGroupRelCustodians
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestionnaireGroupRelCustodians()
    {
        return $this->questionnaireGroupRelCustodians;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $questionnaireGroupRelSources;


    /**
     * Add questionnaireGroupRelSources
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireGroupRelSources $questionnaireGroupRelSources
     * @return QuestionnaireGroups
     */
    public function addQuestionnaireGroupRelSource(\WB\QbankBundle\Entity\QuestionnaireGroupRelSources $questionnaireGroupRelSources)
    {
        $this->questionnaireGroupRelSources[] = $questionnaireGroupRelSources;

        return $this;
    }

    /**
     * Remove questionnaireGroupRelSources
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireGroupRelSources $questionnaireGroupRelSources
     */
    public function removeQuestionnaireGroupRelSource(\WB\QbankBundle\Entity\QuestionnaireGroupRelSources $questionnaireGroupRelSources)
    {
        $this->questionnaireGroupRelSources->removeElement($questionnaireGroupRelSources);
    }

    /**
     * Get questionnaireGroupRelSources
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getQuestionnaireGroupRelSources()
    {
        return $this->questionnaireGroupRelSources;
    }
}
