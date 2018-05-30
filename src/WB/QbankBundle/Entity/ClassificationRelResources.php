<?php

namespace WB\QbankBundle\Entity;

/**
 * ClassificationRelResources
 */
class ClassificationRelResources
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
     * @return ClassificationRelResources
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
     * @return ClassificationRelResources
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
     * Set classificationId
     *
     * @param \WB\QbankBundle\Entity\Classifications $classificationId
     *
     * @return ClassificationRelResources
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
