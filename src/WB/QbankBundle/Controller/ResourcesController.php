<?php

namespace WB\QbankBundle\Controller;

use JMS\TranslationBundle\Translation\ConfigBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WB\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WB\QbankBundle\Entity\Resources;
use WB\QbankBundle\Enums\ActiveButtons;
use WB\QbankBundle\Form\Type\ResourcesType;

class ResourcesController extends Controller
{

    public function resourcesAction($publishedOnly, $search, Request $request)
    {

        $excludedIds = $request->request->get('excludedIds');

        $showPublishedOnly = ($publishedOnly == 'true') ? true : false;

        $paramPublished = $showPublishedOnly ? 1 : false;

        $repository = $this->getDoctrine()->getRepository("WBQbankBundle:Resources");

        $resources = $repository->searchResources($paramPublished, $search, $excludedIds);        

        return $this->render('@WBQbank/Resources/resources.html.twig', array(
            'resources' => $resources,
            'active_button' => ActiveButtons::AdminResources
        ));
    }


    public function addResourceAction(Request $request)
    {

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

    }

    public function editResourceAction($id, Request $request)
    {
        // get resource by id
        $resource = $this->getDoctrine()->getManager()
            ->getRepository('WBQbankBundle:Resources')
            ->find($id);

        if (!$resource) {
            throw $this->createNotFoundException(
                'No resource found'
            );
        }

        // form
        $form = $this->createForm(new ResourcesType(), $resource);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $dir = $this->container->getParameter('resources-upload-path');
            $file = $resource->getFilename();
            
            //to keep the existing uploaded file location
            $filename_=$request->get('filename_');
            
            if (is_object($file)) {
                $resource->setFilesize($file->getSize());
                $filename = time() . $file->getClientOriginalName();
                $file->move($dir, $filename);
                $location = $dir . $filename;
                $resource->setFilename($location);
            }
            else if (trim($filename_)!=""){
                $resource->setFilename($filename_);
            }

            $em = $this->getDoctrine()->getManager();

            $em->flush();

            return $this->redirect($this->generateUrl('resources'));
        }

        return $this->render('WBQbankBundle:Resources:editResource.html.twig', array(
            'form' => $form->createView(),
            'resourceId' => $id,
            'active_button' => ActiveButtons::AdminResources
        ));
    }

    public function deleteResourceAction($id)
    {
        // find resource by id
        $em = $this->getDoctrine()->getManager();
        $resource = $em->getRepository('WBQbankBundle:Resources')
            ->findOneById($id);

        if (!$resource) {
            throw $this->createNotFoundException(
                'No Resource found'
            );
        }

        // delete resource
        $em->remove($resource);
        $em->flush();
        return new Response('ok');
    }

    public function batchDeleteResourcesAction(Request $request)
    {
        $ids = $this->get('request')->request->get('ids');

        // find resources by ids
        $em = $this->getDoctrine()->getManager();
        $resources = $em->getRepository('WBQbankBundle:Resources');

        if (count($ids)) {
            foreach ($ids as $resourceId) {
                $em->remove($resources->find($resourceId));
            }
        }

        if (!$resources) {
            throw $this->createNotFoundException(
                'No Resources found'
            );
        }

        // delete resources
        $em->flush();
        return new Response('ok');
    }

    public function publishUnpublishAction($id, $publish)
    {

        $em = $this->getDoctrine()->getManager();
        $publish = (boolean)$publish;
        $entity = $em->getRepository('WBQbankBundle:Resources')->findOneBy(["id" => $id]);

        $entity->setPublished($publish);
        $em->flush();

        return new Response("ok");
    }


}