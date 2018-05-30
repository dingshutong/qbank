<?php

namespace WB\UserBundle\Entity;

use Doctrine\ORM\Query\Expr\Base;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * User
 */
class User extends BaseUser
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var \WB\QbankBundle\Entity\Countries
     */
    private $countryId;

    /**
     * @var \WB\QbankBundle\Entity\Organizations
     */
    private $companyId;

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
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
     * Set countryId
     *
     * @param \WB\QbankBundle\Entity\Countries $countryId
     *
     * @return User
     */
    public function setCountryId(\WB\QbankBundle\Entity\Countries $countryId = null)
    {
        $this->countryId = $countryId;
    
        return $this;
    }

    /**
     * Get countryId
     *
     * @return \WB\QbankBundle\Entity\Countries
     */
    public function getCountryId()
    {
        return $this->countryId;
    }

    /**
     * Set companyId
     *
     * @param \WB\QbankBundle\Entity\Organizations $companyId
     *
     * @return User
     */
    public function setCompanyId(\WB\QbankBundle\Entity\Organizations $companyId = null)
    {
        $this->companyId = $companyId;
    
        return $this;
    }

    /**
     * Get companyId
     *
     * @return \WB\QbankBundle\Entity\Organizations
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }
    /**
     * @var string
     */
    private $company;


    /**
     * Set company
     *
     * @param string $company
     *
     * @return User
     */
    public function setCompany($company)
    {
        $this->company = $company;
    
        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }
}
