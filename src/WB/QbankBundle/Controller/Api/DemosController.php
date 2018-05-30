<?php

namespace WB\QbankBundle\Controller\Api;

class DemosController
{
    public function getDemoAction($id)
    {
        return array('hello'=>'world');
    }
    
    public function editDemoAction($id)
    {
        return array('hello'=>'world23');
    }
    
    public function removeDemoAction($id)
    {
        return array('hello'=>'world2');
    }
    
    public function editDemoCommentsAction($slug,$id) // demos/{slug}/comments/{id}/edit
    {
        return array('hello'=>'world343434342-comments');
    }
}