<?php

namespace WB\QbankBundle\Entity;

/**
 * QuestionnaireModuleResources
 */
class QuestionnaireModuleResources
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var boolean
     */
    private $useOfLayout;

    /**
     * @var string
     */
    private $location;

    /**
     * @var string
     */
    private $fileType;

    /**
     * @var boolean
     */
    private $published;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var \DateTime
     */
    private $changed;

    /**
     * @var \WB\QbankBundle\Entity\QuestionnaireModules
     */
    private $questModuleId;


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
     * Set title
     *
     * @param string $title
     *
     * @return QuestionnaireModuleResources
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return QuestionnaireModuleResources
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set useOfLayout
     *
     * @param boolean $useOfLayout
     *
     * @return QuestionnaireModuleResources
     */
    public function setUseOfLayout($useOfLayout)
    {
        $this->useOfLayout = $useOfLayout;

        return $this;
    }

    /**
     * Get useOfLayout
     *
     * @return boolean
     */
    public function getUseOfLayout()
    {
        return $this->useOfLayout;
    }

    /**
     * Set location
     *
     * @param string $location
     *
     * @return QuestionnaireModuleResources
     */
    public function setLocation($location)
    {
        if ($location) {
            $this->location = $location;
        }
        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set fileType
     *
     * @param string $fileType
     *
     * @return QuestionnaireModuleResources
     */
    public function setFileType($fileType)
    {
        $this->fileType = $fileType;

        return $this;
    }

    /**
     * Get fileType
     *
     * @return string
     */
    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return QuestionnaireModuleResources
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return QuestionnaireModuleResources
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set changed
     *
     * @param \DateTime $changed
     *
     * @return QuestionnaireModuleResources
     */
    public function setChanged($changed)
    {
        $this->changed = $changed;

        return $this;
    }

    /**
     * Get changed
     *
     * @return \DateTime
     */
    public function getChanged()
    {
        return $this->changed;
    }

    /**
     * Set questModuleId
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireModules $questModuleId
     *
     * @return QuestionnaireModuleResources
     */
    public function setQuestModuleId(\WB\QbankBundle\Entity\QuestionnaireModules $questModuleId = null)
    {
        $this->questModuleId = $questModuleId;

        return $this;
    }

    /**
     * Get questModuleId
     *
     * @return \WB\QbankBundle\Entity\QuestionnaireModules
     */
    public function getQuestModuleId()
    {
        return $this->questModuleId;
    }

    /**
     * @var int
     */
    private $dateAccessed;

    /**
     * Get dateAccessed
     *
     * @return int
     */
    public function getDateAccessed()
    {
        return $this->dateAccessed;
    }

    /**
     * @param int $dateAccessed
     */
    public function setDateAccessed($dateAccessed)
    {
        $this->dateAccessed = $dateAccessed;
    }


}
