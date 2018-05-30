<?php

namespace WB\QbankBundle\Entity;

/**
 * QuestionnaireGroupRelModules
 */
class QuestionnaireGroupRelModules
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $weight;

    /**
     * @var \WB\QbankBundle\Entity\QuestionnaireGroups
     */
    private $questGroupId;

    /**
     * @var \WB\QbankBundle\Entity\QuestionnaireModules
     */
    private $questModuleId;


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
     * Set weight
     *
     * @param integer $weight
     *
     * @return QuestionnaireGroupRelModules
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
     * Set questGroupId
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireGroups $questGroupId
     *
     * @return QuestionnaireGroupRelModules
     */
    public function setQuestGroupId(\WB\QbankBundle\Entity\QuestionnaireGroups $questGroupId = null)
    {
        $this->questGroupId = $questGroupId;
    
        return $this;
    }

    /**
     * Get questGroupId
     *
     * @return \WB\QbankBundle\Entity\QuestionnaireGroups
     */
    public function getQuestGroupId()
    {
        return $this->questGroupId;
    }

    /**
     * Set questModuleId
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireModules $questModuleId
     *
     * @return QuestionnaireGroupRelModules
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
}
