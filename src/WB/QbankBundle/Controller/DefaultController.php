<?php

namespace WB\QbankBundle\Controller;

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

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('WBQbankBundle:Default:index.html.twig', array(
            'active_button' => ActiveButtons::FrontIndex
        ));
    }

    public function indexBackendAction()
    {
        $em = $this->getDoctrine()->getManager();

        // indicators
        $indCount = $em->getRepository('WBQbankBundle:Indicators')
            ->countIndicators();

        $indGrpCount = $em->getRepository('WBQbankBundle:IndicatorGroups')
            ->countIndicatorGroups();

        $indCollCount = $em->getRepository('WBQbankBundle:IndicatorCollections')
            ->countIndicatorCollections();

        // concepts
        $termCount = $em->getRepository('WBQbankBundle:Terms')
            ->countTerms();

        $termGrpCount = $em->getRepository('WBQbankBundle:TermGroups')
            ->countTermGroups();

        // classifications
        $classifCount = $em->getRepository('WBQbankBundle:Classifications')
            ->countClassifications();

        $classifGrpCount = $em->getRepository('WBQbankBundle:ClassificationGroups')
            ->countClassificationGroups();

        // questionaries
        $questCount = $em->getRepository('WBQbankBundle:QuestionnaireModules')
            ->countQuestionnaires();

        $questGrpCount = $em->getRepository('WBQbankBundle:QuestionnaireGroups')
            ->countQuestionnaireGroups();


        return $this->render('WBQbankBundle:Default:indexBackend.html.twig', array(
            'indCount' => $indCount,
            'indGrpCount' => $indGrpCount,
            'indCollCount' => $indCollCount,
            'termCount' => $termCount,
            'termGrpCount' => $termGrpCount,
            'classifCount' => $classifCount,
            'classifGrpCount' => $classifGrpCount,
            'questCount' => $questCount,
            'questGrpCount' => $questGrpCount,
            'active_button' => ActiveButtons::AdminIndex
        ));
    }

    public function indicatorsAction()
    {
        return $this->render('WBQbankBundle:Default:indicators.html.twig', array(
            'active_button' => ActiveButtons::FrontIndicators
        ));
    }

    public function indicatorGroupDataAction($id)
    {
        // find group by id
        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('WBQbankBundle:IndicatorGroups')
            ->find($id);

        // find indicators attached to group
        $indicatorsForMainGroup = array();

        foreach ($group->getIndicatorGrpRef() as $rel) {
            $indicatorsForMainGroup[] = $rel->getIndId();
            end($indicatorsForMainGroup)->setWeight($rel->getWeight());
        }

        usort($indicatorsForMainGroup, ['WB\QbankBundle\Controller\DefaultController', "sortEntity"]);

        // find child groups
        $childGroups = $em->getRepository('WBQbankBundle:IndicatorGroups')
            ->findBy(array('pid' => $id));

        // make array of subgroups and their indicators
        $childGroupsTree = array();

        foreach ($childGroups as $childGroup) {

            $childGroupId = $childGroup->getId();

            $indicatorsForGroup = array();
            foreach ($childGroup->getIndicatorGrpRef() as $rel) {
                $indicatorsForGroup[] = $rel->getIndId();
                end($indicatorsForGroup)->setWeight($rel->getWeight());
            }
            usort($indicatorsForGroup, ['WB\QbankBundle\Controller\DefaultController', "sortEntity"]);

            $childGroupIndicators = array();

            foreach ($indicatorsForGroup as $ind) {
                
                if ($ind->getPublished()){
                    $childGroupIndicators[] = array(
                        'indId' => $ind->getId(),
                        'indName' => $ind->getName(),
                    );
                }
            }

            $childGroupsTree[] = array(
                'name' => $childGroup->getName(),
                'desc' => $childGroup->getDescription(),
                'published' => $childGroup->getPublished(),
                'inds' => $childGroupIndicators
            );

        }

        return $this->render('WBQbankBundle:Default:indicatorGroupData.html.twig', array(
            'group' => $group,
            'indicators' => $indicatorsForMainGroup,
            'childGroupsTree' => $childGroupsTree,
        ));
    }

    public function indicatorCollectionDataAction($id)
    {
        // find collection by id
        $em = $this->getDoctrine()->getManager();
        $collection = $em->getRepository('WBQbankBundle:IndicatorCollections')
            ->find($id);

        // find indicators attached to collection
        $indicatorsForMainCollection = array();
        foreach ($collection->getIndicatorCollRef() as $rel) {
            $indicatorsForMainCollection[] = $rel->getIndId();
            end($indicatorsForMainCollection)->setWeight($rel->getWeight());
        }

        usort($indicatorsForMainCollection, ['WB\QbankBundle\Controller\DefaultController', "sortEntity"]);

        // find child collections
        $collectionId = $collection->getId();
        $childCollections = $em->getRepository('WBQbankBundle:IndicatorCollections')
            ->findBy(array('pid' => $collectionId));

        // make array of subcollections and their indicators
        $childCollectionsTree = array();

        foreach ($childCollections as $childCollection) {

            $childCollectionId = $childCollection->getId();

            $indicatorsForCollection = array();
            foreach ($childCollection->getIndicatorCollRef() as $rel) {
                $indicatorsForCollection[] = $rel->getIndId();
                end($indicatorsForCollection)->setWeight($rel->getWeight());
            }

            usort($indicatorsForCollection, ['WB\QbankBundle\Controller\DefaultController', "sortEntity"]);

            $childCollectionIndicators = array();

            foreach ($indicatorsForCollection as $ind) {

                $childCollectionIndicators[] = array(
                    'indId' => $ind->getId(),
                    'indName' => $ind->getName(),
                );
            }

            $childCollectionsTree[] = array(
                'name' => $childCollection->getName(),
                'desc' => $childCollection->getDescription(),
                'published' => $childCollection->getPublished(),
                'inds' => $childCollectionIndicators
            );

        }

        return $this->render('WBQbankBundle:Default:indicatorCollectionData.html.twig', array(
            'collection' => $collection,
            'indicators' => $indicatorsForMainCollection,
            'childCollectionsTree' => $childCollectionsTree,
        ));
    }

    public function indicatorDataAction($id)
    {
        // get indicator by id
        $indicator = $this->getDoctrine()->getManager()
            ->getRepository('WBQbankBundle:Indicators')
            ->find($id);

        if (!$indicator) {
            throw $this->createNotFoundException(
                'No indicator found'
            );
        }
        
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
        ));
    }

    public function headerMenuAction($activeButton)
    {
        return $this->render('WBQbankBundle:Default:headerMenu.html.twig', array(
            'active_button' => $activeButton,
            'buttons' => new ActiveButtons()
        ));
    }

    public function frontHeaderMenuAction($activeButton)
    {
        return $this->render('WBQbankBundle:Default:frontHeaderMenu.html.twig', array(
            'active_button' => $activeButton,
            'buttons' => new ActiveButtons()
        ));
    }


    /* Concepts Front */

    public function conceptsAction()
    {
        return $this->render('WBQbankBundle:Default:concepts.html.twig', array(
            'active_button' => ActiveButtons::FrontConcepts
        ));
    }

    public function conceptGroupDataAction($id)
    {
        // find group by id
        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('WBQbankBundle:TermGroups')
            ->find($id);

        // find concepts attached to group
        $conceptsForMainGroup = array();
        foreach ($group->getTermGrpRef() as $rel) {
            $conceptsForMainGroup[] = $rel->getTermId();
            end($conceptsForMainGroup)->setWeight($rel->getWeight());
        }
        
        usort($conceptsForMainGroup, ['WB\QbankBundle\Controller\DefaultController', "sortEntity"]);

        // find child groups
        $childGroups = $em->getRepository('WBQbankBundle:TermGroups')
            ->findBy(array('pid' => $id), array('weight' => 'asc'));

        // make array of subgroups and their concepts
        $childGroupsTree = array();

        foreach ($childGroups as $childGroup) {

            $childGroupId = $childGroup->getId();

            $conceptsForGroup = array();
            foreach ($childGroup->getTermGrpRef() as $rel) {
                $conceptsForGroup[] = $rel->getTermId();
                end($conceptsForGroup)->setWeight($rel->getWeight());
            }
            usort($conceptsForGroup, ['WB\QbankBundle\Controller\DefaultController', "sortEntity"]);

            $childGroupConcepts = array();

            foreach ($conceptsForGroup as $con) {

                if ($con->getPublished()){
                    $childGroupConcepts[] = array(
                        'termId' => $con->getId(),
                        'termName' => $con->getName(),
                    );
                }
            }

            $childGroupsTree[] = array(
                'name' => $childGroup->getName(),
                'desc' => $childGroup->getDescription(),
                'published' => $childGroup->getPublished(),
                'concepts' => $childGroupConcepts
            );

        }

        return $this->render('WBQbankBundle:Default:conceptGroupData.html.twig', array(
            'group' => $group,
            'concepts' => $conceptsForMainGroup,
            'childGroupsTree' => $childGroupsTree,
        ));
    }

    public function conceptDataAction($id, $lightbox)
    {
        // get concept by id
        $concept = $this->getDoctrine()->getManager()
            ->getRepository('WBQbankBundle:Terms')
            ->find($id);

        if (!$concept) {
            throw $this->createNotFoundException(
                'No concept found'
            );
        }
        
        
        //get array of resources types
        $resources_doctypes = $this->getDoctrine()
            ->getRepository('WBQbankBundle:DocTypes')
            ->createQueryBuilder('doctypes')
            ->select('doctypes')
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
                      
        
        //get resources
        $resources = array();

        // get resources
        $resourcesRel = $concept->getTermRelResources();
        
        //group resources by type
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
        
        //sources
        $sourcesRel = $concept->getTermRelSources();
        $sources = array();
        foreach ($sourcesRel as $cr) {
            $sources[] = $this->getDoctrine()->getManager()
                ->getRepository('WBQbankBundle:Resources')
                ->find($cr->getResourceId());
        }

        // get organizations
        $organizationsRel = $concept->getTermRelCustodians();
        $organizations = array();
        foreach ($organizationsRel as $or) {
            $organizations[] = $this->getDoctrine()->getManager()
                ->getRepository('WBQbankBundle:Organizations')
                ->find($or->getOrganizationId());
        }

        return $this->render('WBQbankBundle:Default:conceptData.html.twig', array(
            'concept' => $concept,
            'resources' => $resources,
            'sources' => $sources,
            'organizations' => $organizations,
            'lightbox' => $lightbox
        ));
    }


    /* Classifications Front */

    public function classificationsAction()
    {
        return $this->render('WBQbankBundle:Default:classifications.html.twig', array(
            'active_button' => ActiveButtons::FrontClassifications
        ));
    }

    public function classificationDataAction($id, $lightbox)
    {
        // get classification by id
        $classification = $this->getDoctrine()->getManager()
            ->getRepository('WBQbankBundle:Classifications')
            ->find($id);

        if (!$classification) {
            throw $this->createNotFoundException(
                'No classification found'
            );
        }

        
        //get array of resources types
        $resources_doctypes = $this->getDoctrine()
            ->getRepository('WBQbankBundle:DocTypes')
            ->createQueryBuilder('doctypes')
            ->select('doctypes')
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
                      
        
        //get resources
        $resources = array();

        // get resources
        $resourcesRel = $classification->getClassificationRelResources();
        
        //group resources by type
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
        
        
        
        // get sources
        $sourcesRel = $classification->getClassificationRelSources();
        $sources = array();
        foreach ($sourcesRel as $cr) {
            $sources[] = $this->getDoctrine()->getManager()
                ->getRepository('WBQbankBundle:Resources')
                ->find($cr->getResourceId());
        }

        // get organizations
        $organizationsRel = $classification->getClassificationRelCustodians();
        $organizations = array();
        foreach ($organizationsRel as $or) {
            $organizations[] = $this->getDoctrine()->getManager()
                ->getRepository('WBQbankBundle:Organizations')
                ->find($or->getOrganizationId());
        }

        // get concepts
        $conceptsRel = $classification->getClassificationRelTerms();
        $concepts = array();
        foreach ($conceptsRel as $cr) {
            $concepts[] = $this->getDoctrine()->getManager()
                ->getRepository('WBQbankBundle:Terms')
                ->find($cr->getTermId());
        }
        //removing unpublished questionnaires (check is not based on question published value!) items from array
        foreach ($classification->getQuestionClassifications() as $questionClassification) {
            $questionsArray = $classification->getQuestionClassifications();
            if ($questionClassification->getQuestModuleId()->getPublished() == null || $questionClassification->getQuestModuleId()->getPublished() != true) {
                $questionsArray->removeElement($questionClassification);
            }

        }


        return $this->render('WBQbankBundle:Default:classificationData.html.twig', array(
            'classification' => $classification,
            'concepts' => $concepts,
            'resources' => $resources,
            'sources'   => $sources,
            'organizations' => $organizations,
            'lightbox' => $lightbox
        ));
    }


    public function classificationGroupDataAction($id)
    {
        // find group by id
        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('WBQbankBundle:ClassificationGroups')
            ->find($id);

        // find classifications attached to group
        $classificationsForMainGroup = array();
        foreach ($group->getClassificationGrpRef() as $rel) {
            $classificationsForMainGroup[] = $rel->getClassificationId();
        }

        // find child groups
        $childGroups = $em->getRepository('WBQbankBundle:ClassificationGroups')
            ->findBy(array('pid' => $id));


        // make array of subgroups and their classifications
        $childGroupsTree = array();

        foreach ($childGroups as $childGroup) {

            $childGroupId = $childGroup->getId();

            $classificationsForGroup = array();
            foreach ($childGroup->getClassificationGrpRef() as $rel) {
                $classificationsForGroup[] = $rel->getClassificationId();
            }

            $childGroupClassifications = array();

            foreach ($classificationsForGroup as $cla) {
                $childGroupClassifications[] = array(
                    'classificationId' => $cla->getId(),
                    'classificationName' => $cla->getName(),
                );
            }

            $childGroupsTree[] = array(
                'name' => $childGroup->getName(),
                'desc' => $childGroup->getDescription(),
                'classifications' => $childGroupClassifications
            );

        }

        //echo '<pre>';
        //print_r($classificationsForMainGroup);
        //echo '</pre>';

        //echo '<pre>';
        //print_r($classificationsForMainGroup);
        //echo '</pre>';

        return $this->render('WBQbankBundle:Default:classificationGroupData.html.twig', array(
            'group' => $group,
            'classifications' => $classificationsForMainGroup,
            'childGroupsTree' => $childGroupsTree,
        ));
    }


    /* Questionnaires Front */

    public function questionnairesAction()
    {
        return $this->render('WBQbankBundle:Default:questionnaires.html.twig', array(
            'active_button' => ActiveButtons::FrontQuestionnaires
        ));
    }

    public function questionnaireGroupDataAction($id, $lightbox)
    {
        // find group by id
        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('WBQbankBundle:QuestionnaireGroups')
            ->find($id);

        // find questionnaires attached to group
        $questionnairesForMainGroup = array();
        foreach ($group->getQuestionnaireGroupRelModules() as $rel) {
            $questionnairesForMainGroup[] = $rel->getQuestModuleId();
        }

        // find child groups
        $childGroups = $em->getRepository('WBQbankBundle:QuestionnaireGroups')
            ->findBy(array('pid' => $id));

        // make array of subgroups and their questionnaires
        $childGroupsTree = array();

        foreach ($childGroups as $childGroup) {

            $childGroupId = $childGroup->getId();

            $questionnairesForGroup = array();
            foreach ($childGroup->getQuestionnaireGroupRelModules() as $rel) {
                $questionnairesForGroup[] = $rel->getQuestModuleId();
            }

            $childGroupQuestionnaires = array();

            foreach ($questionnairesForGroup as $que) {

                $childGroupQuestionnaires[] = array(
                    'questionnaireId' => $que->getId(),
                    'questionnaireName' => $que->getName(),
                );
            }

            if ($childGroup->getPublished()) {
                $childGroupsTree[] = array(
                    'id' => $childGroup->getId(),
                    'name' => $childGroup->getName(),
                    'desc' => $childGroup->getDescription(),
                    'questionnaires' => $childGroupQuestionnaires
                );
            }
        }

        
        //get array of resources types
        $resources_doctypes = $this->getDoctrine()
            ->getRepository('WBQbankBundle:DocTypes')
            ->createQueryBuilder('doctypes')
            ->select('doctypes')
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
                      
        
        //get resources
        $resources = array();

        // get resources
        $resourcesRel = $group->getQuestionnaireGroupRelResources();
        
        //group resources by type
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
            
        //sources
        $sourcesRel = $group->getQuestionnaireGroupRelSources();
        $sources = array();
        foreach ($sourcesRel as $cr) {
            $sources[] = $this->getDoctrine()->getManager()
                ->getRepository('WBQbankBundle:Resources')
                ->find($cr->getResourceId());
        }

        // get organizations
        $organizationsRel = $group->getQuestionnaireGroupRelCustodians();
        $organizations = array();
        foreach ($organizationsRel as $or) {
            $organizations[] = $this->getDoctrine()->getManager()
                ->getRepository('WBQbankBundle:Organizations')
                ->find($or->getOrganizationId());
        }


        return $this->render('WBQbankBundle:Default:questionnaireGroupData.html.twig', array(
            'group' => $group,
            'questionnaires' => $questionnairesForMainGroup,
            'childGroupsTree' => $childGroupsTree,
            'resources' => $resources,
            'sources'=>$sources,
            'organizations' => $organizations,
            'lightbox' => $lightbox
        ));
    }

    public function questionnaireDataAction($id, $questionId, $lightbox)
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

        $layout = null;
        $resources = array();
        if ($lightbox) {
            $layout = false;
        }

        //get array of resources types
        $resources_doctypes = $this->getDoctrine()
            ->getRepository('WBQbankBundle:DocTypes')
            ->createQueryBuilder('doctypes')
            ->select('doctypes')
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
                      
        
        // get resources
        $questModuleRelResources = $this->getDoctrine()->getManager()->getRepository('WBQbankBundle:QuestionnaireModulesRelResources')->findBy(["questModuleId" => $id]);
        
        //get resources and sources
        $resources = array();
        
        //group resources by doctype
        foreach ($questModuleRelResources as $cr) {
            $resourceModel = $this->getDoctrine()->getManager()
                ->getRepository('WBQbankBundle:Resources')
                ->find($cr->getResourceId());
                
            $resource_doc_type=$resourceModel->getDocType()->getTitle();    
             
            if (!$resource_doc_type){
                $resource_doc_type='Other';                
            }
            
            if (!$lightbox && $cr->getUseOfLayout()) {
                $layout = $resourceModel;
            }
            
            $resources[$resource_doc_type][]=$resourceModel;
        }        
        
                
        //sources
        $sourcesRel = $this->getDoctrine()->getManager()->getRepository('WBQbankBundle:QuestionnaireModulesRelSources')->findBy(["questModuleId" => $id]);
        $sources = array();
        foreach ($sourcesRel as $cr) {
            $sources[] = $this->getDoctrine()->getManager()
                ->getRepository('WBQbankBundle:Resources')
                ->find($cr->getResourceId());
        }
        
        return $this->render('WBQbankBundle:Default:questionnaireData.html.twig', array(
            'questionnaire' => $questionnaire,
            'layout' => $layout,
            'resources' => $resources,
            'sources' => $sources,
            'questionId' => $questionId,
            'lightbox' => $lightbox
        ));
    }

    public function questionDataAction($id, $lightbox)
    {
        // get question by id
        $question = $this->getDoctrine()->getManager()
            ->getRepository('WBQbankBundle:QuestionnaireModuleQuestions')
            ->find($id);

        if (!$question) {
            throw $this->createNotFoundException(
                'No question found'
            );
        }

        $view = $lightbox ? 'WBQbankBundle:Default:questionDataLightbox.html.twig' : 'WBQbankBundle:Default:questionData.html.twig';

        return $this->render($view, array(
            'question' => $question
        ));
    }


    public function visualRepFormatAction($visualRepFormat, $valRepFormat, $isFront = false, $questionId = false, $classification = false)
    {
        switch ($visualRepFormat) {
            case QuestionVisualRepresentationFormats::Numeric:
                $info = array(
                    "val_rep_format" => $valRepFormat,
                    "numeric" => explode(".", $valRepFormat)
                );
                return $this->render('@WBQbank/Default/Partials/valueRepFormatNumber.html.twig', array(
                    "info" => $info
                ));
            case QuestionVisualRepresentationFormats::Text:
                $info = $valRepFormat;
                return $this->render('@WBQbank/Default/Partials/valueRepFormatText.html.twig', array(
                    "info" => $valRepFormat,
                ));
            case QuestionVisualRepresentationFormats::ClassificationList:
                if ($isFront) {
                    $codes = $this->getDoctrine()->getRepository("WBQbankBundle:QuestionnaireModuleQuestions")->getQuestionClassificationCodes($questionId, $classification->getId(), true);
                    $dataset = array();

                    foreach ($codes as $code) {
                        $dataset[] = array(
                            "label" => $code->getLabel(),
                            "value" => $code->getValue(),
                            "skipValue" => $code->getQuestionsRelClassifications()->first() ? $code->getQuestionsRelClassifications()->first()->getSkipValue() : ""
                        );
                    }
                    return $this->render('@WBQbank/Default/Partials/valueRepFormatClassificationList.html.twig', array('codes' => $dataset));
                } else {
                    return new Response("");
                }
            default:
                return new Response("");
                break;
        }
    }


    /* Resources Front */

    public function resourceAction($id, $lightbox)
    {

        $resource = $this->getDoctrine()->getManager()
            ->getRepository('WBQbankBundle:Resources')
            ->find($id);

        if (!$resource) {
            throw $this->createNotFoundException(
                'No resource found'
            );
        }

        return $this->render('WBQbankBundle:Default:resource.html.twig', array(
            'resource' => $resource,
            'lightbox' => $lightbox
        ));
    }


    /* Organizations Front */

    public function organizationAction($id, $lightbox)
    {

        $organization = $this->getDoctrine()->getManager()
            ->getRepository('WBQbankBundle:Organizations')
            ->find($id);

        if (!$organization) {
            throw $this->createNotFoundException(
                'No organization found'
            );
        }

        return $this->render('WBQbankBundle:Default:organization.html.twig', array(
            'organization' => $organization,
            'lightbox' => $lightbox
        ));
    }


    /**
     * Renders organizations modal
     */
    public function organizationsModalAction($entityName, $propertyName, $search = false, Request $request)
    {
        $excludedIds = $request->request->get('excludedIds');
        $organizations = $this->getDoctrine()->getManager()->getRepository('WBQbankBundle:Organizations')->searchOrganizations(false, $search, $excludedIds);
        if ($search) {
            return $this->render('WBQbankBundle:Shared/partials:organizationsModalPartial.html.twig', array(
                'organizations' => $organizations,
            ));
        } else {
            return $this->render('WBQbankBundle:Shared:organizationsModal.html.twig', array(
                'organizations' => $organizations,
                'entity_name' => $entityName,
                'property_name' => $propertyName
            ));
        }
    }

    /**
     * Renders resources modal
     */
    public function resourcesModalAction($entityName, $propertyName, $search = false, Request $request)
    {
        $excludedIds = $request->request->get('excludedIds');
        $resources = $this->getDoctrine()->getManager()->getRepository('WBQbankBundle:Resources')->searchResources(false, $search, $excludedIds);
        if ($search) {
            return $this->render('WBQbankBundle:Shared/partials:resourcesModalPartial.html.twig', array(
                'resources' => $resources,
            ));
        } else {
            return $this->render('WBQbankBundle:Shared:resourcesModal.html.twig', array(
                'resources' => $resources,
                'entity_name' => $entityName,
                'property_name' => $propertyName
            ));
        }
    }
    
    
    
    /**
     * Renders sources modal
     */
    public function sourcesModalAction($entityName, $propertyName, $search = false, Request $request)
    {
        $excludedIds = $request->request->get('excludedIds');
        $resources = $this->getDoctrine()->getManager()->getRepository('WBQbankBundle:Resources')->searchResources(false, $search, $excludedIds);
        if ($search) {
            return $this->render('WBQbankBundle:Shared/partials:resourcesModalPartial.html.twig', array(
                'resources' => $resources,
            ));
        } else {
            return $this->render('WBQbankBundle:Shared:sourcesModal.html.twig', array(
                'resources' => $resources,
                'entity_name' => $entityName,
                'property_name' => $propertyName
            ));
        }
    }
    
    

    /**
     * Renders classifications modal
     */
    public function classificationsModalAction($entityName, $propertyName, $search = false, Request $request)
    {
        $excludedIds = $request->request->get('excludedIds');

        $grpTree = $this->get('helpers')->makeClassificationTree(false, $search, $excludedIds);

        $grpTree = $this->get('helpers')->cleanUpTree($grpTree);

        if ($search) {
            return $this->render('WBQbankBundle:Shared/partials:classificationsModalPartial.html.twig', array(
                'tree' => $grpTree,
                'entity_name' => $entityName
            ));
        } else {
            return $this->render('WBQbankBundle:Shared:classificationsModal.html.twig', array(
                'tree' => $grpTree,
                'entity_name' => $entityName,
                'property_name' => $propertyName
            ));
        }
    }
    

    /**
     * Renders concepts modal
     */
    public function conceptsModalAction($entityName, $propertyName, $search = false, Request $request)
    {
        $excludedIds = $request->request->get('excludedIds');
        $concepts = $this->getDoctrine()->getManager()->getRepository('WBQbankBundle:Terms')->searchTerms(false, false, $search, $excludedIds);
        if ($search) {
            return $this->render('WBQbankBundle:Shared/partials:conceptsModalPartial.html.twig', array(
                'concepts' => $concepts,
            ));
        } else {
            return $this->render('WBQbankBundle:Shared:conceptsModal.html.twig', array(
                'concepts' => $concepts,
                'entity_name' => $entityName,
                'property_name' => $propertyName
            ));
        }
    }

    /**
     * Renders questionnaires modal
     */
    public function questionnairesModalAction($entityName, $propertyName, $search = false, Request $request)
    {
        $excludedIds = $request->request->get('excludedIds');

        $grpTree = $this->get('helpers')->makeQuestionnaireTree(false, $search, $excludedIds);

        $grpTree = $this->get('helpers')->cleanUpTree($grpTree);

        if ($search) {
            return $this->render('WBQbankBundle:Shared/partials:questionnairesModalPartial.html.twig', array(
                'tree' => $grpTree,
            ));
        } else {
            return $this->render('WBQbankBundle:Shared:questionnairesModal.html.twig', array(
                'tree' => $grpTree,
                'entity_name' => $entityName,
                'property_name' => $propertyName
            ));
        }
    }

    public function addQuestionModalAction()
    {
        $question = new QuestionnaireModuleQuestions();
        $form = $this->createForm(new QuestionsType(), $question);
        return $this->render("@WBQbank/Shared/addQuestionModal.html.twig", array(
            "form" => $form->createView()
        ));
    }

    private static function sortEntity($a, $b)
    {
        if ($a->getWeight() == $b->getWeight()) {
            return 0;
        }
        return ($a->getWeight() < $b->getWeight()) ? -1 : 1;
    }
}
