<?php
namespace WB\QbankBundle\Twig;

use \Twig_Extension;
use \Twig_SimpleFilter;

class Filters extends Twig_Extension {

    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('customSort', array($this, 'myCustomSort')),
        );
    }
    public function myCustomSort($arg1)
    {
            return usort($arg1->vars->value->classificationCodeId, array($this, 'sort'));
    }

    public function sort($a, $b){
        if($a->getClassificationCodeId()->getWeight() > $b->getClassificationCodeId()->getWeight()){
            return -1;
        }
        else {
            return 1;
        }
    }

    public function getName()
    {
        return 'filters';
    }
} 