<?php

namespace WB\QbankBundle\Entity;

/**
 * ClassificationCodes
 */
class ClassificationCodes
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $label;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $value;

    /**
     * @var boolean
     */
    private $isMissing;

    /**
     * @var integer
     */
    private $weight;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $questionsRelClassifications;

    /**
     * @var \WB\QbankBundle\Entity\Classifications
     */
    private $classificationId;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->questionsRelClassifications = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set id
     *
     * @param string $id
     *
     * @return ClassificationCodes
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set label
     *
     * @param string $label
     *
     * @return ClassificationCodes
     */
    public function setLabel($label)
    {
        $this->label = $label;
    
        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return ClassificationCodes
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
     * Set value
     *
     * @param string $value
     *
     * @return ClassificationCodes
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set isMissing
     *
     * @param boolean $isMissing
     *
     * @return ClassificationCodes
     */
    public function setIsMissing($isMissing)
    {
        $this->isMissing = $isMissing;
    
        return $this;
    }

    /**
     * Get isMissing
     *
     * @return boolean
     */
    public function getIsMissing()
    {
        return $this->isMissing;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     *
     * @return ClassificationCodes
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
     * Add questionsRelClassifications
     *
     * @param \WB\QbankBundle\Entity\QuestionsRelClassifications $questionsRelClassifications
     *
     * @return ClassificationCodes
     */
    public function addQuestionsRelClassification(\WB\QbankBundle\Entity\QuestionsRelClassifications $questionsRelClassifications)
    {
        $this->questionsRelClassifications[] = $questionsRelClassifications;
    
        return $this;
    }

    /**
     * Remove questionsRelClassifications
     *
     * @param \WB\QbankBundle\Entity\QuestionsRelClassifications $questionsRelClassifications
     */
    public function removeQuestionsRelClassification(\WB\QbankBundle\Entity\QuestionsRelClassifications $questionsRelClassifications)
    {
        $this->questionsRelClassifications->removeElement($questionsRelClassifications);
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
     * Set classificationId
     *
     * @param \WB\QbankBundle\Entity\Classifications $classificationId
     *
     * @return ClassificationCodes
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

    /**
     * Set questionsRelClassifications
     *
     * @param \WB\QbankBundle\Entity\QuestionsRelClassifications $questionsRelClassifications
     *
     * @return ClassificationCodes
     */
    public function setQuestionsRelClassifications(\WB\QbankBundle\Entity\QuestionsRelClassifications $questionsRelClassifications = null)
    {
        $this->questionsRelClassifications = $questionsRelClassifications;
    
        return $this;
    }
    /**
     * @var string
     */
    private $attachments;


    /**
     * Set attachments
     *
     * @param string $attachments
     * @return ClassificationCodes
     */
    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;

        return $this;
    }

    /**
     * Get attachments
     *
     * @return string 
     */
    public function getAttachments()
    {
        return $this->attachments;
    }
}
