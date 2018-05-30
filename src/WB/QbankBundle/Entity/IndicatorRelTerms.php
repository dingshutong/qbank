<?php

namespace WB\QbankBundle\Entity;

/**
 * IndicatorRelTerms
 */
class IndicatorRelTerms
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
     * @var \WB\QbankBundle\Entity\Indicators
     */
    private $indId;

    /**
     * @var \WB\QbankBundle\Entity\Terms
     */
    private $termId;


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
     * @return IndicatorRelTerms
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
     * Set indId
     *
     * @param \WB\QbankBundle\Entity\Indicators $indId
     *
     * @return IndicatorRelTerms
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

    /**
     * Set termId
     *
     * @param \WB\QbankBundle\Entity\Terms $termId
     *
     * @return IndicatorRelTerms
     */
    public function setTermId(\WB\QbankBundle\Entity\Terms $termId = null)
    {
        $this->termId = $termId;
    
        return $this;
    }

    /**
     * Get termId
     *
     * @return \WB\QbankBundle\Entity\Terms
     */
    public function getTermId()
    {
        return $this->termId;
    }
}
