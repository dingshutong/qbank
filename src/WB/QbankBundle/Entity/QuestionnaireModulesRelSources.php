<?php

namespace WB\QbankBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuestionnaireModulesRelSources
 */
class QuestionnaireModulesRelSources
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
     * @var \WB\QbankBundle\Entity\Resources
     */
    private $resourceId;

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
     * @return QuestionnaireModulesRelSources
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
     * Set resourceId
     *
     * @param \WB\QbankBundle\Entity\Resources $resourceId
     * @return QuestionnaireModulesRelSources
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

    /**
     * Set questModuleId
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireModules $questModuleId
     * @return QuestionnaireModulesRelSources
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
