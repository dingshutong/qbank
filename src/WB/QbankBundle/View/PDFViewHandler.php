<?php

namespace WB\QbankBundle\View;

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PDFViewHandler
{
    public function __construct()
    {
        
    }
    
    public function createResponse(ViewHandler $handler, View $view, Request $request, $format)
    {
        $data=$view->getData();
        
        echo $data->getId();
        
        var_dump(get_class($data));
        
        die("nothing happens");
        
        
        $pdf="pdf file content";
        die("it works");
        return new Response($pdf,200, $view->getHeaders());
    }
}