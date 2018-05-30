<?php

namespace WB\QbankBundle\Entity;

/**
 * IndCollectionRef
 */
class IndCollectionRef
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
     * @var \WB\QbankBundle\Entity\IndicatorCollections
     */
    private $indCollId;

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
     * @return IndCollectionRef
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
     * Set indCollId
     *
     * @param \WB\QbankBundle\Entity\IndicatorCollections $indCollId
     *
     * @return IndCollectionRef
     */
    public function setIndCollId(\WB\QbankBundle\Entity\IndicatorCollections $indCollId = null)
    {
        $this->indCollId = $indCollId;
    
        return $this;
    }

    /**
     * Get indCollId
     *
     * @return \WB\QbankBundle\Entity\IndicatorCollections
     */
    public function getIndCollId()
    {
        return $this->indCollId;
    }

    /**
     * Set indId
     *
     * @param \WB\QbankBundle\Entity\Indicators $indId
     *
     * @return IndCollectionRef
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
