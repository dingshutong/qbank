<?php
/**
 * Created by PhpStorm.
 * User: Neske
 * Date: 3/7/2015
 * Time: 6:49 PM
 */

namespace WB\QbankBundle\DTO;


class ClassificationCodeDTO {

    public $id;
    public $question_id;
    public $label;
    public $value;
    public $skipValue;
    public $classification_id;


    function __construct($id = null, $label = null, $value = null, $question_id = null, $skip = null, $classification_id = null)
    {
        $this->id = $id;
        $this->question_id = $question_id;
        $this->label = $label;
        $this->value = $value;
        $this->skipValue = $skip;
        $this->classification_id = $classification_id;
    }


}