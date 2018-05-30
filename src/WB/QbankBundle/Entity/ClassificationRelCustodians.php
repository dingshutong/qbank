<?php

namespace WB\QbankBundle\Entity;

/**
 * ClassificationRelCustodians
 */
class ClassificationRelCustodians
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
     * @var \WB\QbankBundle\Entity\Classifications
     */
    private $classificationId;


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
     * @return ClassificationRelCustodians
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
     * @return ClassificationRelCustodians
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
     * Set classificationId
     *
     * @param \WB\QbankBundle\Entity\Classifications $classificationId
     *
     * @return ClassificationRelCustodians
     */
    public function setClassificationId(\WB\QbankBundle\Entity\Classifications $classificationId = null)
    {
        $this->classificationId = $classificationId;
    
        return $this;
    }

    /**
     * Get classificationId
     *
     * @return \WB\QbankBundle\Entity\Classifications
     */
    public function getClassificationId()
    {
        return $this->classificationId;
    }
}
