<?php

namespace WB\QbankBundle\Entity;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * QuestionnaireModuleQuestions
 *
 * @ExclusionPolicy("all") 
 */
class QuestionnaireModuleQuestions
{
    /**
     * @var integer
     * @expose
     */
    private $id;

    /**
     * @var string
     */
    private $alternateId;

    /**
     * @var string
     * @expose
     */
    private $name;

    /**
     * @var string
     * @expose
     */
    private $description;

    /**
     * @var string
     * @expose
     */
    private $preText;

    /**
     * @var string
     * @expose
     */
    private $literalText;

    /**
     * @var string
     * @expose
     */
    private $postText;

    /**
     * @var string
     * @expose
     */
    private $valRepFormat;

    /**
     * @var string
     * @expose
     */
    private $valPostText;

    /**
     * @var string
     * @expose
     */
    private $visualRepFormat;

    /**
     * @var string
     * @expose
     */
    private $notes;

    /**
     * @var string
     * @expose
     */
    private $instructions;

    /**
     * @var string
     * @expose
     */
    private $universe;

    /**
     * @var integer
     * @expose
     */
    private $weight;

    /**
     * @var boolean
     */
    private $published;

    /**
     * @var \DateTime
     * @expose
     */
    private $created;

    /**
     * @var \DateTime
     * @expose
     */
    private $changed;

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
     * @return QuestionnaireModuleQuestions
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
     * @return QuestionnaireModuleQuestions
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
     * @return QuestionnaireModuleQuestions
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
     * Set preText
     *
     * @param string $preText
     *
     * @return QuestionnaireModuleQuestions
     */
    public function setPreText($preText)
    {
        $this->preText = $preText;
    
        return $this;
    }

    /**
     * Get preText
     *
     * @return string
     */
    public function getPreText()
    {
        return $this->preText;
    }

    /**
     * Set literalText
     *
     * @param string $literalText
     *
     * @return QuestionnaireModuleQuestions
     */
    public function setLiteralText($literalText)
    {
        $this->literalText = $literalText;
    
        return $this;
    }

    /**
     * Get literalText
     *
     * @return string
     */
    public function getLiteralText()
    {
        return $this->literalText;
    }

    /**
     * Set postText
     *
     * @param string $postText
     *
     * @return QuestionnaireModuleQuestions
     */
    public function setPostText($postText)
    {
        $this->postText = $postText;
    
        return $this;
    }

    /**
     * Get postText
     *
     * @return string
     */
    public function getPostText()
    {
        return $this->postText;
    }

    /**
     * Set valRepFormat
     *
     * @param string $valRepFormat
     *
     * @return QuestionnaireModuleQuestions
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
     * Set valPostText
     *
     * @param string $valPostText
     *
     * @return QuestionnaireModuleQuestions
     */
    public function setValPostText($valPostText)
    {
        $this->valPostText = $valPostText;
    
        return $this;
    }

    /**
     * Get valPostText
     *
     * @return string
     */
    public function getValPostText()
    {
        return $this->valPostText;
    }

    /**
     * Set visualRepFormat
     *
     * @param string $visualRepFormat
     *
     * @return QuestionnaireModuleQuestions
     */
    public function setVisualRepFormat($visualRepFormat)
    {
        $this->visualRepFormat = $visualRepFormat;
    
        return $this;
    }

    /**
     * Get visualRepFormat
     *
     * @return string
     */
    public function getVisualRepFormat()
    {
        return $this->visualRepFormat;
    }

    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return QuestionnaireModuleQuestions
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
     * Set instructions
     *
     * @param string $instructions
     *
     * @return QuestionnaireModuleQuestions
     */
    public function setInstructions($instructions)
    {
        $this->instructions = $instructions;
    
        return $this;
    }

    /**
     * Get instructions
     *
     * @return string
     */
    public function getInstructions()
    {
        return $this->instructions;
    }

    /**
     * Set universe
     *
     * @param string $universe
     *
     * @return QuestionnaireModuleQuestions
     */
    public function setUniverse($universe)
    {
        $this->universe = $universe;
    
        return $this;
    }

    /**
     * Get universe
     *
     * @return string
     */
    public function getUniverse()
    {
        return $this->universe;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     *
     * @return QuestionnaireModuleQuestions
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
     * @return QuestionnaireModuleQuestions
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
     * @return QuestionnaireModuleQuestions
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
     * @return QuestionnaireModuleQuestions
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
    private $visualRepInfo;


    /**
     * Set visualRepInfo
     *
     * @param string $visualRepInfo
     *
     * @return QuestionnaireModuleQuestions
     */
    public function setVisualRepInfo($visualRepInfo)
    {
        $this->visualRepInfo = $visualRepInfo;
    
        return $this;
    }

    /**
     * Get visualRepInfo
     *
     * @return string
     */
    public function getVisualRepInfo()
    {
        return $this->visualRepInfo;
    }
    /**
     * @var \WB\QbankBundle\Entity\QuestionnaireModules
     */
    private $questModuleId;


    /**
     * Set questModuleId
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireModules $questModuleId
     *
     * @return QuestionnaireModuleQuestions
     */
    public function setQuestModuleId(\WB\QbankBundle\Entity\QuestionnaireModules $questModuleId = null)
    {
        $this->questModuleId = $questModuleId;
    
        return $this;
    }

    /**
     * Get questModuleId
     *
     * @return \WB\QbankBundle\Entity\QuestionnaireModules
     */
    public function getQuestModuleId()
    {
        return $this->questModuleId;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $questionsRelClassifications;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->questionsRelClassifications = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add questionsRelClassification
     *
     * @param \WB\QbankBundle\Entity\QuestionsRelClassifications $questionsRelClassification
     *
     * @return QuestionnaireModuleQuestions
     */
    public function addQuestionsRelClassification(\WB\QbankBundle\Entity\QuestionsRelClassifications $questionsRelClassification)
    {
        $this->questionsRelClassifications[] = $questionsRelClassification;
    
        return $this;
    }

    /**
     * Remove questionsRelClassification
     *
     * @param \WB\QbankBundle\Entity\QuestionsRelClassifications $questionsRelClassification
     */
    public function removeQuestionsRelClassification(\WB\QbankBundle\Entity\QuestionsRelClassifications $questionsRelClassification)
    {
        $this->questionsRelClassifications->removeElement($questionsRelClassification);
    }

    /**
     * Get questionsRelClassifications
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestionsRelClassifications()
    {
        return $this->questionsRelClassifications;
    }
    /**
     * @var \WB\QbankBundle\Entity\Classifications
     */
    private $classificationId;


    /**
     * Set classificationId
     *
     * @param \WB\QbankBundle\Entity\Classifications $classificationId
     *
     * @return QuestionnaireModuleQuestions
     */
    public function setClassificationId(\WB\QbankBundle\Entity\Classifications $classificationId = null)
    {
        $this->classificationId = $classificationId;
    
        return $this;
    }

    /**
     * Get classificationId
     *
     * @return \WB\QbankBundle\Entity\Classifications
     */
    public function getClassificationId()
    {
        return $this->classificationId;
    }

}
