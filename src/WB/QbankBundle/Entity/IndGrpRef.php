<?php

namespace WB\QbankBundle\Entity;

/**
 * IndGrpRef
 */
class IndGrpRef
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
     * @var \WB\QbankBundle\Entity\IndicatorGroups
     */
    private $indGroupId;

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
     * @return IndGrpRef
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
     * Set indGroupId
     *
     * @param \WB\QbankBundle\Entity\IndicatorGroups $indGroupId
     *
     * @return IndGrpRef
     */
    public function setIndGroupId(\WB\QbankBundle\Entity\IndicatorGroups $indGroupId = null)
    {
        $this->indGroupId = $indGroupId;
    
        return $this;
    }

    /**
     * Get indGroupId
     *
     * @return \WB\QbankBundle\Entity\IndicatorGroups
     */
    public function getIndGroupId()
    {
        return $this->indGroupId;
    }

    /**
     * Set indId
     *
     * @param \WB\QbankBundle\Entity\Indicators $indId
     *
     * @return IndGrpRef
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
