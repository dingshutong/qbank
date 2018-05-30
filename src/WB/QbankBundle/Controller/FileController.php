<?php

namespace WB\QbankBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WB\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WB\QbankBundle\Entity\Resources;
use Symfony\Component\HttpFoundation\JsonResponse;

class FileController extends Controller
{

    public function uploadFileAction(Request $request)
    {
        
        /*
        var_dump($_FILES);
        echo "<HR>";
        var_dump($_POST);
        echo "<HR>";
        var_dump($_GET);
        echo "<HR>";
        */
        
        //allowed file types
        $allowed_extensions=explode(",",'png,jpg,gif,jpeg');
                
        $file = $this->getRequest()->files->get('file');
        
        //validate file type
        if (!in_array($file->guessExtension(), $allowed_extensions))  
        {
          $output=array(
                'status'=>'error',    
                'message'=>'file type not supported: '.$file->guessExtension()
            );
        
            //return new Response(json_encode($output));
        
            //throw new Symfony\Component\HttpKernel\Exception\HttpException(500, 'file type not supported: '.$file->guessExtension());
            
            return new JsonResponse($output, 419);
        }
        
        $fileName = uniqid().'-'.$file->getClientOriginalName(); //md5(uniqid()).'.'.$file->guessExtension();
        
        // Move the file to the temp directory
        $uploads_dir = $this->container->getParameter('resources-upload-path').'cls-codes';
        $file->move($uploads_dir, $fileName);

        /*
                var_dump($file);
        echo "<HR>";
        

        
        var_dump($uploads_dir);
        
        var_dump($fileName);
        */
        
        $output=array(
                'status'=>'success',
                'filename'=>$fileName,
                'path'=>'cls-codes/'.$fileName
        );
        
        return new Response(json_encode($output));
        
        
        /*
        $dir = $this->container->getParameter('resources-upload-path');
        $file = $resource->getFilename();
        if (is_object($file)) {
            $resource->setFilesize($file->getSize());
            $filename = time() . $file->getClientOriginalName();
            $file->move($dir, $filename);
            $location = $dir . $filename;
            $resource->setFilename($location);
        }
        */
    
        /*
        $resource = new Resources();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new ResourcesType(), $resource);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $date = new \DateTime("now");
            $resource->setChanged($date);
            $resource->setCreated($date);
            $resource->setPublished(0);

            $dir = $this->container->getParameter('resources-upload-path');
            $file = $resource->getFilename();
            if (is_object($file)) {
                $resource->setFilesize($file->getSize());
                $filename = time() . $file->getClientOriginalName();
                $file->move($dir, $filename);
                $location = $dir . $filename;
                $resource->setFilename($location);
            }

            $em->persist($resource);
            $em->flush();

            return $this->redirect($this->generateUrl('resources'));
        }

        return $this->render('@WBQbank/Resources/addResource.html.twig', array(
            'form' => $form->createView(),
            'active_button' => ActiveButtons::AdminResources
        ));
        */
        
        return new Response('ok');

    }

    


}