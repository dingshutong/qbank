<?php

namespace WB\QbankBundle\Entity;

/**
 * ClassificationGrpRef
 */
class ClassificationGrpRef
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
     * @var \WB\QbankBundle\Entity\ClassificationGroups
     */
    private $classificationGroupId;

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
     * @return ClassificationGrpRef
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
     * Set classificationGroupId
     *
     * @param \WB\QbankBundle\Entity\ClassificationGroups $classificationGroupId
     *
     * @return ClassificationGrpRef
     */
    public function setClassificationGroupId(\WB\QbankBundle\Entity\ClassificationGroups $classificationGroupId = null)
    {
        $this->classificationGroupId = $classificationGroupId;
    
        return $this;
    }

    /**
     * Get classificationGroupId
     *
     * @return \WB\QbankBundle\Entity\ClassificationGroups
     */
    public function getClassificationGroupId()
    {
        return $this->classificationGroupId;
    }

    /**
     * Set classificationId
     *
     * @param \WB\QbankBundle\Entity\Classifications $classificationId
     *
     * @return ClassificationGrpRef
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
