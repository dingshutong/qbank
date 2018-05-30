<?php

namespace WB\QbankBundle\Entity;

/**
 * QuestionnaireGroupRelCustodians
 */
class QuestionnaireGroupRelCustodians
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
     * @var \WB\QbankBundle\Entity\QuestionnaireGroups
     */
    private $questGroupId;

    /**
     * @var \WB\QbankBundle\Entity\Organizations
     */
    private $organizationId;


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
     * @return QuestionnaireGroupRelCustodians
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
     * Set questGroupId
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireGroups $questGroupId
     *
     * @return QuestionnaireGroupRelCustodians
     */
    public function setQuestGroupId(\WB\QbankBundle\Entity\QuestionnaireGroups $questGroupId = null)
    {
        $this->questGroupId = $questGroupId;
    
        return $this;
    }

    /**
     * Get questGroupId
     *
     * @return \WB\QbankBundle\Entity\QuestionnaireGroups
     */
    public function getQuestGroupId()
    {
        return $this->questGroupId;
    }

    /**
     * Set organizationId
     *
     * @param \WB\QbankBundle\Entity\Organizations $organizationId
     *
     * @return QuestionnaireGroupRelCustodians
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
}
