<?php

namespace WB\QbankBundle\Entity;

/**
 * TermGrpRef
 */
class TermGrpRef
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
     * @var \WB\QbankBundle\Entity\Terms
     */
    private $termId;

    /**
     * @var \WB\QbankBundle\Entity\TermGroups
     */
    private $termGroupId;


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
     * @return TermGrpRef
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
     * Set termId
     *
     * @param \WB\QbankBundle\Entity\Terms $termId
     *
     * @return TermGrpRef
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

    /**
     * Set termGroupId
     *
     * @param \WB\QbankBundle\Entity\TermGroups $termGroupId
     *
     * @return TermGrpRef
     */
    public function setTermGroupId(\WB\QbankBundle\Entity\TermGroups $termGroupId = null)
    {
        $this->termGroupId = $termGroupId;
    
        return $this;
    }

    /**
     * Get termGroupId
     *
     * @return \WB\QbankBundle\Entity\TermGroups
     */
    public function getTermGroupId()
    {
        return $this->termGroupId;
    }
}
