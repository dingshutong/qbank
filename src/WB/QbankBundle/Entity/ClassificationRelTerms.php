<?php

namespace WB\QbankBundle\Entity;

/**
 * ClassificationRelTerms
 */
class ClassificationRelTerms
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
     * @var \WB\QbankBundle\Entity\Classifications
     */
    private $classificationId;

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
     * @return ClassificationRelTerms
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
     * Set classificationId
     *
     * @param \WB\QbankBundle\Entity\Classifications $classificationId
     *
     * @return ClassificationRelTerms
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

    /**
     * Set termId
     *
     * @param \WB\QbankBundle\Entity\Terms $termId
     *
     * @return ClassificationRelTerms
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
