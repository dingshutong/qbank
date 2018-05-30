<?php

namespace WB\QbankBundle\Entity;

/**
 * QuestionnaireGroupRelResources
 */
class QuestionnaireGroupRelResources
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
     * @var \WB\QbankBundle\Entity\Resources
     */
    private $resourceId;


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
     * @return QuestionnaireGroupRelResources
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
     * @return QuestionnaireGroupRelResources
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
     * Set resourceId
     *
     * @param \WB\QbankBundle\Entity\Resources $resourceId
     *
     * @return QuestionnaireGroupRelResources
     */
    public function setResourceId(\WB\QbankBundle\Entity\Resources $resourceId = null)
    {
        $this->resourceId = $resourceId;
    
        return $this;
    }

    /**
     * Get resourceId
     *
     * @return \WB\QbankBundle\Entity\Resources
     */
    public function getResourceId()
    {
        return $this->resourceId;
    }
}
