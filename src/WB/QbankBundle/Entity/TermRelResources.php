<?php

namespace WB\QbankBundle\Entity;

/**
 * TermRelResources
 */
class TermRelResources
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
     * @return TermRelResources
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
     *
     * @return TermRelResources
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
     * Set termId
     *
     * @param \WB\QbankBundle\Entity\Terms $termId
     *
     * @return TermRelResources
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
