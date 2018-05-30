<?php

namespace WB\QbankBundle\Entity;

/**
 * TermRelCustodians
 */
class TermRelCustodians
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
     * @return TermRelCustodians
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
     * @return TermRelCustodians
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
     * Set termId
     *
     * @param \WB\QbankBundle\Entity\Terms $termId
     *
     * @return TermRelCustodians
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
