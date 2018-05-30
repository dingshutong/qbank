<?php

namespace WB\QbankBundle\Entity;

/**
 * Organizations
 */
class Organizations
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $alternateId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $nickName;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $areaCode;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $telephone;

    /**
     * @var string
     */
    private $fax;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $notes;

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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $indicatorRelCustodians;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $termRelCustodians;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $questionnaireGroupRelCustodians;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->indicatorRelCustodians = new \Doctrine\Common\Collections\ArrayCollection();
        $this->termRelCustodians = new \Doctrine\Common\Collections\ArrayCollection();
        $this->questionnaireGroupRelCustodians = new \Doctrine\Common\Collections\ArrayCollection();
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set alternateId
     *
     * @param string $alternateId
     *
     * @return Organizations
     */
    public function setAlternateId($alternateId)
    {
        $this->alternateId = $alternateId;
    
        return $this;
    }

    /**
     * Get alternateId
     *
     * @return string
     */
    public function getAlternateId()
    {
        return $this->alternateId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Organizations
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
     * Set description
     *
     * @param string $description
     *
     * @return Organizations
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
     * Set nickName
     *
     * @param string $nickName
     *
     * @return Organizations
     */
    public function setNickName($nickName)
    {
        $this->nickName = $nickName;
    
        return $this;
    }

    /**
     * Get nickName
     *
     * @return string
     */
    public function getNickName()
    {
        return $this->nickName;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Organizations
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set areaCode
     *
     * @param string $areaCode
     *
     * @return Organizations
     */
    public function setAreaCode($areaCode)
    {
        $this->areaCode = $areaCode;
    
        return $this;
    }

    /**
     * Get areaCode
     *
     * @return string
     */
    public function getAreaCode()
    {
        return $this->areaCode;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Organizations
     */
    public function setCountry($country)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Organizations
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    
        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set fax
     *
     * @param string $fax
     *
     * @return Organizations
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    
        return $this;
    }

    /**
     * Get fax
     *
     * @return string
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Organizations
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Organizations
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return Organizations
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    
        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Organizations
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
     * @return Organizations
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
     * @return Organizations
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
     * Add indicatorRelCustodians
     *
     * @param \WB\QbankBundle\Entity\IndicatorRelCustodians $indicatorRelCustodians
     *
     * @return Organizations
     */
    public function addIndicatorRelCustodian(\WB\QbankBundle\Entity\IndicatorRelCustodians $indicatorRelCustodians)
    {
        $this->indicatorRelCustodians[] = $indicatorRelCustodians;
    
        return $this;
    }

    /**
     * Remove indicatorRelCustodians
     *
     * @param \WB\QbankBundle\Entity\IndicatorRelCustodians $indicatorRelCustodians
     */
    public function removeIndicatorRelCustodian(\WB\QbankBundle\Entity\IndicatorRelCustodians $indicatorRelCustodians)
    {
        $this->indicatorRelCustodians->removeElement($indicatorRelCustodians);
    }

    /**
     * Get indicatorRelCustodians
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIndicatorRelCustodians()
    {
        return $this->indicatorRelCustodians;
    }

    /**
     * Add termRelCustodians
     *
     * @param \WB\QbankBundle\Entity\TermRelCustodians $termRelCustodians
     *
     * @return Organizations
     */
    public function addTermRelCustodian(\WB\QbankBundle\Entity\TermRelCustodians $termRelCustodians)
    {
        $this->termRelCustodians[] = $termRelCustodians;
    
        return $this;
    }

    /**
     * Remove termRelCustodians
     *
     * @param \WB\QbankBundle\Entity\TermRelCustodians $termRelCustodians
     */
    public function removeTermRelCustodian(\WB\QbankBundle\Entity\TermRelCustodians $termRelCustodians)
    {
        $this->termRelCustodians->removeElement($termRelCustodians);
    }

    /**
     * Get termRelCustodians
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTermRelCustodians()
    {
        return $this->termRelCustodians;
    }

    /**
     * Add questionnaireGroupRelCustodians
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireGroupRelCustodians $questionnaireGroupRelCustodians
     *
     * @return Organizations
     */
    public function addQuestionnaireGroupRelCustodian(\WB\QbankBundle\Entity\QuestionnaireGroupRelCustodians $questionnaireGroupRelCustodians)
    {
        $this->questionnaireGroupRelCustodians[] = $questionnaireGroupRelCustodians;
    
        return $this;
    }

    /**
     * Remove questionnaireGroupRelCustodians
     *
     * @param \WB\QbankBundle\Entity\QuestionnaireGroupRelCustodians $questionnaireGroupRelCustodians
     */
    public function removeQuestionnaireGroupRelCustodian(\WB\QbankBundle\Entity\QuestionnaireGroupRelCustodians $questionnaireGroupRelCustodians)
    {
        $this->questionnaireGroupRelCustodians->removeElement($questionnaireGroupRelCustodians);
    }

    /**
     * Get questionnaireGroupRelCustodians
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestionnaireGroupRelCustodians()
    {
        return $this->questionnaireGroupRelCustodians;
    }

    /**
     * Add users
     *
     * @param \WB\UserBundle\Entity\User $users
     *
     * @return Organizations
     */
    public function addUser(\WB\UserBundle\Entity\User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \WB\UserBundle\Entity\User $users
     */
    public function removeUser(\WB\UserBundle\Entity\User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $classificationRelCustodians;


    /**
     * Add classificationRelCustodians
     *
     * @param \WB\QbankBundle\Entity\ClassificationRelCustodians $classificationRelCustodians
     *
     * @return Organizations
     */
    public function addClassificationRelCustodian(\WB\QbankBundle\Entity\ClassificationRelCustodians $classificationRelCustodians)
    {
        $this->classificationRelCustodians[] = $classificationRelCustodians;
    
        return $this;
    }

    /**
     * Remove classificationRelCustodians
     *
     * @param \WB\QbankBundle\Entity\ClassificationRelCustodians $classificationRelCustodians
     */
    public function removeClassificationRelCustodian(\WB\QbankBundle\Entity\ClassificationRelCustodians $classificationRelCustodians)
    {
        $this->classificationRelCustodians->removeElement($classificationRelCustodians);
    }

    /**
     * Get classificationRelCustodians
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClassificationRelCustodians()
    {
        return $this->classificationRelCustodians;
    }
}
