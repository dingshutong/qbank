<?php

namespace WB\QbankBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuestionnaireModulesRelResources
 */
class QuestionnaireModulesRelResources
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
     * @var integer
     */
    private $resourceId;

    /**
     * @var integer
     */
    private $questModuleId;

    /**
     * @var boolean
     */
    private $useOfLayout;


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
     * @return QuestionnaireModulesRelResources
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
     * @param Resources $resourceId
     * @return QuestionnaireModulesRelResources
     */
    public function setResourceId($resourceId)
    {
        $this->resourceId = $resourceId;

        return $this;
    }

    /**
     * Get resourceId
     *
     * @return integer 
     */
    public function getResourceId()
    {
        return $this->resourceId;
    }

    /**
     * Set questModuleid
     *
     * @param QuestionnaireModules $questModuleId
     * @return QuestionnaireModulesRelResources
     */
    public function setQuestModuleId($questModuleId)
    {
        $this->questModuleId = $questModuleId;

        return $this;
    }

    /**
     * Get questModuleId
     *
     * @return integer 
     */
    public function getQuestModuleId()
    {
        return $this->questModuleId;
    }

    /**
     * Set useOfLayout
     *
     * @param boolean $useOfLayout
     * @return QuestionnaireModulesRelResources
     */
    public function setUseOfLayout($useOfLayout)
    {
        $this->useOfLayout = $useOfLayout;

        return $this;
    }

    /**
     * Get useOfLayout
     *
     * @return boolean 
     */
    public function getUseOfLayout()
    {
        return $this->useOfLayout;
    }
}
