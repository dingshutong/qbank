<?php

namespace WB\QbankBundle\Entity;

/**
 * QuestionsRelClassifications
 */
class QuestionsRelClassifications
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $skipValue;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $questionnaireModuleQuestions;

    /**
     * @var \WB\QbankBundle\Entity\ClassificationCodes
     */
    private $classificationCodeId;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->questionnaireModuleQuestions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set skipValue
     *
     * @param string $skipValue
     *
     * @return QuestionsRelClassifications
     */
    public function setSkipValue($skipValue)
    {
        $this->skipValue = $skipValue;
    
        return $this;
    }

    /**
     * Get skipValue
     *
     * @return string
     */
    public function getSkipValue()
    {
        return $this->skipValue;
    }

    /**
     * Add questionnaireModuleQuestions
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireModuleQuestions $questionnaireModuleQuestions
     *
     * @return QuestionsRelClassifications
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
     * Set classificationCodeId
     *
     * @param \WB\QbankBundle\Entity\ClassificationCodes $classificationCodeId
     *
     * @return QuestionsRelClassifications
     */
    public function setClassificationCodeId(\WB\QbankBundle\Entity\ClassificationCodes $classificationCodeId = null)
    {
        $this->classificationCodeId = $classificationCodeId;

        return $this;
    }

    /**
     * Get classificationCodeId
     *
     * @return \WB\QbankBundle\Entity\ClassificationCodes
     */
    public function getClassificationCodeId()
    {
        return $this->classificationCodeId;
    }

    /**
     * Set questionnaireModuleQuestions
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireModuleQuestions $questionnaireModuleQuestions
     *
     * @return QuestionsRelClassifications
     */
    public function setQuestionnaireModuleQuestions(\WB\QbankBundle\Entity\QuestionnaireModuleQuestions $questionnaireModuleQuestions = null)
    {
        $this->questionnaireModuleQuestions = $questionnaireModuleQuestions;
    
        return $this;
    }
    /**
     * @var \WB\QbankBundle\Entity\QuestionnaireModuleQuestions
     */
    private $questionId;


    /**
     * Set questionId
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireModuleQuestions $questionId
     *
     * @return QuestionsRelClassifications
     */
    public function setQuestionId(\WB\QbankBundle\Entity\QuestionnaireModuleQuestions $questionId = null)
    {
        $this->questionId = $questionId;
    
        return $this;
    }

    /**
     * Get questionId
     *
     * @return \WB\QbankBundle\Entity\QuestionnaireModuleQuestions
     */
    public function getQuestionId()
    {
        return $this->questionId;
    }
}
