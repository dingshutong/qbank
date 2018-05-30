<?php
/**
 * Created by PhpStorm.
 * User: Neske
 * Date: 3/4/2015
 * Time: 4:59 PM
 */

namespace WB\QbankBundle\DTO;


class QuestionnaireResourceDTO {

    private $id;
    private $title;
    private $description;
    private $location;
    private $useOfLayout;
    private $fileType;

    /**
     * @return mixed
     */
    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * @param mixed $fileType
     */
    public function setFileType($fileType)
    {
        $this->fileType = $fileType;
    }

    /**
     * @return mixed
     */
    public function getUseOfLayout()
    {
        return $this->useOfLayout;
    }

    /**
     * @param mixed $useOfLayout
     */
    public function setUseOfLayout($useOfLayout)
    {
        $this->useOfLayout = $useOfLayout;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }



    function __construct($id, $title, $description, $location, $useOfLayout,$fileType)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->location = $location;
        $this->useOfLayout = $useOfLayout;
        $this->fileType = $fileType;
    }


}