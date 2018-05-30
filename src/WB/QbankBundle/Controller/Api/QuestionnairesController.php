<?php

namespace WB\QbankBundle\Controller\Api;

use JsonSchema\Constraints\EnumConstraint;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WB\QbankBundle\Enums\ActiveButtons;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WB\QbankBundle\Entity\QuestionnaireModuleQuestions;
use WB\QbankBundle\Enums\DocTypes;
use WB\QbankBundle\Enums\QuestionVisualRepresentationFormats;
use WB\QbankBundle\Form\Type\QuestionsType;
use Symfony\Component\Filesystem\Filesystem;
use FOS\RestBundle\Controller\FOSRestController;


class QuestionnairesController extends FOSRestController
{
    public function getQuestionnaireAction($id)
    {        
        // get questionnaire by id
        $questionnaire = $this->getDoctrine()->getManager()
            ->getRepository('WBQbankBundle:QuestionnaireModules')
            ->find($id);

        if (!$questionnaire) {
            throw $this->createNotFoundException(
                'No questionnaire found'
            );
        }
        
        return $questionnaire;
     
        // get resources
        $resourcesRel = $indicator->getIndicatorRelResources();
        
        //get sources
        $sourcesRel =$indicator->getIndicatorRelSources();
        
        //get resources and sources
        $resources = array();
        $sources=array();
        
        //group resources by doctype
        foreach ($resourcesRel as $cr) {
            $resourceModel = $this->getDoctrine()->getManager()
                ->getRepository('WBQbankBundle:Resources')
                ->find($cr->getResourceId());
                
            $resource_doc_type=$resourceModel->getDocType()->getTitle();    
            
            
            if (!$resource_doc_type){
                $resource_doc_type='Other';                
            }                
            
            $resources[$resource_doc_type][]=$resourceModel;
        }
                
        
        foreach ($sourcesRel as $cr) {
            $resourceModel = $this->getDoctrine()->getManager()
                ->getRepository('WBQbankBundle:Resources')
                ->find($cr->getResourceId());                
                $sources[]=$resourceModel;
        }
        
        $result['resources']=$resources;
        $result['sources']=$sources;
        return $result;
        
        
        //$demo= new Demo;
        
        // get indicator by id
        $indicator = $this->getDoctrine()->getManager()
            ->getRepository('WBQbankBundle:Indicators')
            ->find($id);

        return $indicator;
    
        /* $indicator = $this->getDoctrine()
               ->getRepository('WBQbankBundle:Indicators')
               ->createQueryBuilder('e')
               ->select('e')
               ->where('e.id=:id')
               ->setParameter('id',$id)
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);   
        */
        
        $format="xml";
        $serializer = $this->container->get('jms_serializer');
        return $serializer->serialize($indicator, $format);
        //$data = $serializer->deserialize($inputStr, $typeName, $format);
        
        
        
        die();
        //// working example using the symfony stuff
        
        // get indicator by id
        $indicator = $this->getDoctrine()->getManager()
            ->getRepository('WBQbankBundle:Indicators')
            ->find($id);

        if (!$indicator) {
            throw $this->createNotFoundException(
                'No indicator found'
            );
        }
        
        $result = $this->getDoctrine()
               ->getRepository('WBQbankBundle:Indicators')
               ->createQueryBuilder('e')
               ->select('e')
               ->where('e.id=:id')
               ->setParameter('id',$id)
               ->getQuery()
               ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        
        return $result;
    
        var_dump($result);die();        
        /*
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);
        
        
        $normalizer = new GetSetMethodNormalizer();
        $normalizer->setIgnoredAttributes(array('match')); //Replace match with the parent attribute
        $encoder = new JsonEncoder();

        $serializer = new Serializer(array($normalizer), array($encoder));

        echo '<pre>';
        \Doctrine\Common\Util\Debug::dump($indicator);

        
        $json = $serializer->serialize($indicator, 'json');

        
        var_dump($json);
        die();
        */

        echo '<pre>';
        \Doctrine\Common\Util\Debug::dump($indicator);exit;
        
        $format='json';
        
        $serializer = $this->get('serializer');

        $json=$serializer->serialize($indicator, $format);
        //$data = $serializer->deserialize($inputStr, $typeName, $format);
    
    var_dump($json);die();
    
        return $json;
    
    return $indicator;        
        /*
        
        //get array of resources types
        $resources_doctypes = $this->getDoctrine()
            ->getRepository('WBQbankBundle:DocTypes')
            ->createQueryBuilder('doctypes')
            ->select('doctypes')
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
               
               
        
        // get resources
        $resourcesRel = $indicator->getIndicatorRelResources();
        
        //get sources
        $sourcesRel =$indicator->getIndicatorRelSources();
        
        //get resources and sources
        $resources = array();
        $sources=array();
        
        //group resources by doctype
        foreach ($resourcesRel as $cr) {
            $resourceModel = $this->getDoctrine()->getManager()
                ->getRepository('WBQbankBundle:Resources')
                ->find($cr->getResourceId());
                
            $resource_doc_type=$resourceModel->getDocType()->getTitle();    
            
            
            if (!$resource_doc_type){
                $resource_doc_type='Other';                
            }                
            
            $resources[$resource_doc_type][]=$resourceModel;
        }
                
        
        foreach ($sourcesRel as $cr) {
            $resourceModel = $this->getDoctrine()->getManager()
                ->getRepository('WBQbankBundle:Resources')
                ->find($cr->getResourceId());                
                $sources[]=$resourceModel;
        }


        // get organizations
        $organizationsRel = $indicator->getIndicatorRelCustodians();
        $organizations = array();
        foreach ($organizationsRel as $or) {
            $organizations[] = $this->getDoctrine()->getManager()
                ->getRepository('WBQbankBundle:Organizations')
                ->find($or->getOrganizationId());
        }

        // get classifications
        $classificationsRel = $indicator->getIndicatorRelClassifications();
        $classifications = array();
        foreach ($classificationsRel as $cr) {
            $classifications[] = $this->getDoctrine()->getManager()
                ->getRepository('WBQbankBundle:Classifications')
                ->find($cr->getClassificationId());
        }

        // get concepts
        $conceptsRel = $indicator->getIndicatorRelTerms();
        $concepts = array();
        foreach ($conceptsRel as $cr) {
            $concepts[] = $this->getDoctrine()->getManager()
                ->getRepository('WBQbankBundle:Terms')
                ->find($cr->getTermId());
        }

        // get questionnaire modules
        $questionnaireRel = $indicator->getIndicatorRelModules();
        $questionnaires = array();
        foreach ($questionnaireRel as $qr) {
            $questionnaires[] = $this->getDoctrine()->getManager()
                ->getRepository('WBQbankBundle:QuestionnaireModules')
                ->find($qr->getModuleId());
        }

        //remove unpublished rows
        foreach ($questionnaires as $key => $question) {
            if ($question->getPublished() != 1) {
                unset($questionnaires[$key]);
            }
        }


        return $this->render('WBQbankBundle:Default:indicatorData.html.twig', array(
            'indicator' => $indicator,
            'resources' => $resources,
            'sources'=>$sources,
            'organizations' => $organizations,
            'classifications' => $classifications,
            'concepts' => $concepts,
            'questionnaires' => $questionnaires
        ));    */
    
    }
    
    public function searchIndicatorAction()
    {
        $data="search indicator";
        
        return $data;
    }
}
