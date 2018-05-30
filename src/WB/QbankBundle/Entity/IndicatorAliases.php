<?php

namespace WB\QbankBundle\Entity;

/**
 * IndicatorAliases
 */
class IndicatorAliases
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

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
     * Set name
     *
     * @param string $name
     *
     * @return IndicatorAliases
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set indId
     *
     * @param \WB\QbankBundle\Entity\Indicators $indId
     *
     * @return IndicatorAliases
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
