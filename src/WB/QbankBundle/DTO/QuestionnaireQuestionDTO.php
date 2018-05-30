<?php
/**
 * Created by PhpStorm.
 * User: Neske
 * Date: 3/4/2015
 * Time: 2:43 PM
 */

namespace WB\QbankBundle\DTO;


class QuestionnaireQuestionDTO {

    private $id;
    private $name;
    private $description;
    private $weight;
    private $visualRepFormat;
    private $classificationId;
    private $classificationName;

    /**
     * @return mixed
     */
    public function getClassificationId()
    {
        return $this->classificationId;
    }

    /**
     * @param mixed $classificationId
     */
    public function setClassificationId($classificationId)
    {
        $this->classificationId = $classificationId;
    }

    /**
     * @return mixed
     */
    public function getClassificationName()
    {
        return $this->classificationName;
    }

    /**
     * @param mixed $classificationName
     */
    public function setClassificationName($classificationName)
    {
        $this->classificationName = $classificationName;
    }

    /**
     * @return mixed
     */
    public function getVisualRepFormat()
    {
        return $this->visualRepFormat;
    }

    /**
     * @param mixed $visualRepFormat
     */
    public function setVisualRepFormat($visualRepFormat)
    {
        $this->visualRepFormat = $visualRepFormat;
    }

    function __construct($id, $name, $description, $weight,$visualRepFormat,$classificationId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->weight = $weight;
        $this->visualRepFormat = $visualRepFormat;
        $this->classificationId = $classificationId;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    } //?


}