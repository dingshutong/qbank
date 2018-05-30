<?php

namespace WB\QbankBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IndicatorRelSources
 */
class IndicatorRelSources
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
     * @return IndicatorRelSources
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
     * @return IndicatorRelSources
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
     * Set indId
     *
     * @param \WB\QbankBundle\Entity\Indicators $indId
     * @return IndicatorRelSources
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
