<?php

namespace WB\QbankBundle\Entity;

/**
 * IndicatorRelCustodians
 */
class IndicatorRelCustodians
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
     * @var \WB\QbankBundle\Entity\Organizations
     */
    private $organizationId;

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
     * @return IndicatorRelCustodians
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
     * Set organizationId
     *
     * @param \WB\QbankBundle\Entity\Organizations $organizationId
     *
     * @return IndicatorRelCustodians
     */
    public function setOrganizationId(\WB\QbankBundle\Entity\Organizations $organizationId = null)
    {
        $this->organizationId = $organizationId;
    
        return $this;
    }

    /**
     * Get organizationId
     *
     * @return \WB\QbankBundle\Entity\Organizations
     */
    public function getOrganizationId()
    {
        return $this->organizationId;
    }

    /**
     * Set indId
     *
     * @param \WB\QbankBundle\Entity\Indicators $indId
     *
     * @return IndicatorRelCustodians
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
