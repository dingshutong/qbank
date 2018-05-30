<?php

namespace WB\QbankBundle\Entity;

/**
 * IndicatorRelModules
 */
class IndicatorRelModules
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
     * @var \WB\QbankBundle\Entity\QuestionnaireModules
     */
    private $moduleId;

    /**
     * @var \WB\QbankBundle\Entity\Indicators
     */
    private $indId;


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
     * @return IndicatorRelModules
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
     * Set moduleId
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireModules $moduleId
     *
     * @return IndicatorRelModules
     */
    public function setModuleId(\WB\QbankBundle\Entity\QuestionnaireModules $moduleId = null)
    {
        $this->moduleId = $moduleId;
    
        return $this;
    }

    /**
     * Get moduleId
     *
     * @return \WB\QbankBundle\Entity\QuestionnaireModules
     */
    public function getModuleId()
    {
        return $this->moduleId;
    }

    /**
     * Set indId
     *
     * @param \WB\QbankBundle\Entity\Indicators $indId
     *
     * @return IndicatorRelModules
     */
    public function setIndId(\WB\QbankBundle\Entity\Indicators $indId = null)
    {
        $this->indId = $indId;
    
        return $this;
    }

    /**
     * Get indId
     *
     * @return \WB\QbankBundle\Entity\Indicators
     */
    public function getIndId()
    {
        return $this->indId;
    }
}
