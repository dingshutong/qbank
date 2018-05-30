<?php

namespace WB\QbankBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuestionnaireGroupRelSources
 */
class QuestionnaireGroupRelSources
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
     * @return QuestionnaireGroupRelSources
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
     * @return QuestionnaireGroupRelSources
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
     * @return QuestionnaireGroupRelSources
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
