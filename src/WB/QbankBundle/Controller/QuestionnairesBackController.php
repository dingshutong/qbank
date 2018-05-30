<?php

namespace WB\QbankBundle\Controller;

use Doctrine\ORM\EntityManager;
use MyProject\Proxies\__CG__\stdClass;
use Proxies\__CG__\WB\QbankBundle\Entity\Resources;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use WB\QbankBundle\DTO\ClassificationCodeDTO;
use WB\QbankBundle\DTO\QuestionnaireQuestionDTO;
use WB\QbankBundle\Entity\ClassificationCodes;
use WB\QbankBundle\Entity\ClassificationCodesRepository;
use WB\QbankBundle\Entity\Classifications;
use WB\QbankBundle\Entity\QuestionnaireGroupRelModules;
use WB\QbankBundle\Entity\QuestionnaireModuleQuestions;
use WB\QbankBundle\Entity\QuestionnaireModuleResources;
use WB\QbankBundle\Entity\QuestionnaireModulesRelResources;
use WB\QbankBundle\Entity\QuestionnaireModulesRelSources;
use WB\QbankBundle\Entity\QuestionnaireModulesRepository;
use WB\QbankBundle\Entity\QuestionsRelClassifications;
use WB\QbankBundle\Entity\QuestionsRelClassificationsRepository;
use WB\QbankBundle\Enums\DocTypes;
use WB\QbankBundle\Enums\QuestionVisualRepresentationFormats;
use WB\QbankBundle\Form\Type\QuestionsType;
use WB\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WB\QbankBundle\Entity\QuestionnaireModules;
use WB\QbankBundle\Entity\QuestionnaireGroups;
use WB\QbankBundle\Form\Type\QuestionnaireGroupsType;
use WB\QbankBundle\Form\Type\QuestionnairesEditType;
use WB\QbankBundle\Form\Type\QuestionnairesType;
use WB\QbankBundle\Enums\ActiveButtons;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use WB\QbankBundle\Form\Type\RelClassificationsType;
use WB\QbankBundle\Form\Type\RelClassificationCodeType;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class QuestionnairesBackController extends Controller
{
    public function questionnairesAction()
    {
        return $this->render(
            '@WBQbank/QuestionnairesBack/questionnaires.html.twig',
            array(
                'active_button' => ActiveButtons::AdminQuestionnaires
            )
        );
    }

    public function updateQuestionnaire($id, $published)
    {
        $em = $this->getDoctrine()->getManager();
        QuestionnaireModulesRepository::updateQuestionnairePublished($em, $id, $published);
    }

    public function addQuestionnaireAction(Request $request, $idForCloning)
    {

        $em = $this->getDoctrine()->getManager();

        if ($idForCloning) {
            $questionnaire = $this->cloneQuestionnaire($idForCloning, $em);
        } else {

            $questionnaire = new QuestionnaireModules();

            $name = $this->get('request')->request->get('name');
            $grpId = $this->get('request')->request->get('grpId');

            // set reference to group
            if ($grpId != 0) {

                // Questionnaire group object
                $questionnaireGrp = $em->getRepository('WBQbankBundle:QuestionnaireGroups')
                    ->find($grpId);

                if ($questionnaireGrp) {
                    $questionnaireGrpRef = new QuestionnaireGroupRelModules();
                    $questionnaireGrpRef->setQuestGroupId($questionnaireGrp);
                    $questionnaireGrpRef->setQuestModuleId($questionnaire);
                    $questionnaireGrpRef->setWeight(0);
                    $em->persist($questionnaireGrpRef);
                }
            }

            $questionnaire->setName($name);
            $questionnaire->setWeight(0);
        }

        $em->persist($questionnaire);
        $em->flush();

        // return new questionnaire id
        return new Response($questionnaire->getId());
    }

    public function questionnaireGroupsAction($publishedOnly, $search)
    {
        $showPublishedOnly = ($publishedOnly == 'true') ? true : false;

        $questGroupsRepo = $this->getDoctrine()
            ->getRepository('WBQbankBundle:QuestionnaireGroups');

        // groups at zero level
        $startLevelGroups = (!$showPublishedOnly)
            ? $questGroupsRepo->findByPid(0, array('weight' => 'asc'))
            : $questGroupsRepo->findBy(array('pid' => 0, 'published' => true), array('weight' => 'asc'));

        /* creating an array of groups and related questionnaires */
        $questRepository = $this->getDoctrine()
            ->getRepository('WBQbankBundle:QuestionnaireModules');

        $paramPublished = $showPublishedOnly ? 1 : false;

        $grpTree = $this->get('helpers')->makeQuestionnaireTree($showPublishedOnly, $search);

        if ($search) {
            $grpTree = $this->get('helpers')->cleanUpTree($grpTree);
        }

        $countGroups = $this->get('helpers')->countTree($grpTree);

        if (count($grpTree)) {
            $groups = $grpTree['sub'];
        } else {
            $groups = array();
        }
        if ($showPublishedOnly) {
            $groups = $this->get('helpers')->removeEmptyGroups($groups);
        }

        return $this->render('WBQbankBundle:QuestionnairesBack:questionnaireGroups.html.twig', array(
            'groups' => $groups,
            'countGroups' => $countGroups
        ));
    }

    public function questionnaireRepositoryAction($filterAssigned, $filterPublished, $search, Request $request)
    {

        $excludedIds = $request->request->get('excludedIds');

        $repository = $this->getDoctrine()->getRepository("WBQbankBundle:QuestionnaireModules");

        switch ($filterPublished) {
            case "yes" :
                $paramPublished = 1;
                break;
            case "no" :
                $paramPublished = 0;
                break;
            default :
                $paramPublished = false;
                break;
        }

        switch ($filterAssigned) {
            case "yes" :
                $paramAssigned = "NOT NULL";
                break;
            case "no" :
                $paramAssigned = "NULL";
                break;
            default :
                $paramAssigned = false;
                break;
        }

        $questionnaires = $repository->searchQuestionnaires($paramAssigned, $paramPublished, $search, $excludedIds);

        return $this->render('WBQbankBundle:QuestionnairesBack:questionnaireRepository.html.twig', array(
            'questionnaires' => $questionnaires,
            'countQuestionnaires' => count($questionnaires),
            'active_button' => ActiveButtons::AdminQuestionnaires
        ));

    }

    public function editQuestionnaireGroupAction($id, Request $request)
    {

        // get group by id
        $questionnaireGroup = $this->getDoctrine()->getManager()
            ->getRepository('WBQbankBundle:QuestionnaireGroups')
            ->find($id);

        if (!$questionnaireGroup) {
            throw $this->createNotFoundException(
                'No group found'
            );
        }

    
        // form
        $form = $this->createForm(new QuestionnaireGroupsType(), $questionnaireGroup);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();

            foreach ($questionnaireGroup->getQuestionnaireGroupRelCustodians() as $custodian) {
                if ($custodian->getOrganizationId() == null) {
                    $em->remove($custodian);
                } else {
                    $custodian->setQuestGroupId($questionnaireGroup);
                }
            }

            //resources
            foreach ($questionnaireGroup->getQuestionnaireGroupRelResources() as $resource) {
                if ($resource->getResourceId() == null) {
                    $em->remove($resource);
                } else {
                    $resource->setQuestGroupId($questionnaireGroup);
                }
            }
            
            //sources
            foreach ($questionnaireGroup->getQuestionnaireGroupRelSources() as $resource) {
                if ($resource->getResourceId() == null) {
                    $em->remove($resource);
                } else {
                    $resource->setQuestGroupId($questionnaireGroup);
                }
            }

            $em->flush();

            return new Response('ok');
        }

        return $this->render("@WBQbank/QuestionnairesBack/editQuestionnaireGroup.html.twig", array(
            "form" => $form->createView(),
            "grpId" => $id
        ));
    }

    public function addQuestionnaireGroupAction(Request $request, $idForCloning)
    {
        $em = $this->getDoctrine()->getManager();

        if ($idForCloning) {
            $this->cloneQuestionnaireGroup($idForCloning, $em);
        } else {
            $questionnaireGroup = new QuestionnaireGroups();

            $name = $this->get('request')->request->get('name');
            $pid = $this->get('request')->request->get('pid');

            $questionnaireGroup->setName($name);
            $questionnaireGroup->setPid($pid);
            $questionnaireGroup->setPublished(0);
            $em->persist($questionnaireGroup);
            $em->flush();
        }


        // return new group id
        return new Response($questionnaireGroup->getId());
    }

    
    public function saveQuestionnaireAction(Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();

        $questionnaire = json_decode($request->request->get("questionnaire"));
                        
        if ($questionnaire != null) {
            $questionnaireModel = $em->getRepository('WBQbankBundle:QuestionnaireModules')->findOneBy(["id" => $questionnaire->id]);
            $questionnaireModel->setName($questionnaire->name);
            $questionnaireModel->setDescription($questionnaire->description);
            $questionnaireModel->setNotes($questionnaire->notes);
            $em->flush();
        }
        
        $module_id=$questionnaireModel->getId();        
   
        //update questions///////////////////////////////////////////////////////////////////////////////////////////////
        $related_questions=NULL;
        $related_questions_str = $request->request->get("questions");
        parse_str($related_questions_str, $related_questions);
        
        if (isset($related_questions['QuestionnaireEdit']['QuestionModuleRelQuestions']))
        {
           $related_questions=$related_questions['QuestionnaireEdit']['QuestionModuleRelQuestions'];
        }
        
        foreach($related_questions as $key=>$value)
         {
                $related_questions_id_arr[]=$value['questionId'];
                
                //get a reference to the related question if it exists
                $questionnaireModuleQuestion = $em->getRepository("WBQbankBundle:QuestionnaireModuleQuestions")
                    ->findOneBy(["id" => $value['questionId']]);
                
                //only update if Question exists
                if (empty($questionnaireModuleQuestion)) {
                    //skip empty
                    continue;
                }    
                
                //update question weight
                $questionnaireModuleQuestion->setWeight($value['weight']);

                //save
                $em->persist($questionnaireModuleQuestion);
                $em->flush();
                
         }//end-for-each
         
         
         //remove questions from the table that are not in the list
        $result = $em->getRepository('WBQbankBundle:QuestionnaireModuleQuestions')->batchRemoveQuestions($module_id,$related_questions_id_arr);
        
        
        //update resources ///////////////////////////////////////////////////////////////////////////////////////////////
        $related_resources=NULL;
        $related_resources_str = $request->request->get("resources");
        parse_str($related_resources_str, $related_resources);
        
         if (isset($related_resources['QuestionnaireEdit']['QuestionModuleRelResources']))
         {
            $related_resources=$related_resources['QuestionnaireEdit']['QuestionModuleRelResources'];
         }
         
         $use_layout_id=NULL;
         
         $related_resources_id_arr=array();//an array of relresources resourceID list
         
         //remove the key useOfLayout
         foreach($related_resources as $key=>$value)
         {
            if ($key=='useOfLayout')
            {
                $use_layout_id=$value;
                unset($related_resources[$key]);
            }
            else{                
                
                $related_resources_id_arr[]=$value['resourceId'];
                
                //get a reference to the related resource if it exists
                $questionnaireRelResource = $em->getRepository("WBQbankBundle:QuestionnaireModulesRelResources")
                    ->findOneBy(["resourceId" => $value['resourceId'],"questModuleId"=>$module_id]);
                
                //create a new related resource, if not exists
                if (empty($questionnaireRelResource)) {
                    
                    //get the object references for resource and module
                    $resource = $em->getRepository('WBQbankBundle:Resources')->find($value['resourceId']);
                    $quest_module = $em->getRepository('WBQbankBundle:QuestionnaireModules')->find($module_id);
                    
                    $questionnaireRelResource = new QuestionnaireModulesRelResources();
                    $questionnaireRelResource->setQuestModuleId($quest_module);
                    $questionnaireRelResource->setResourceId($resource);
                    $questionnaireRelResource->setWeight($value['weight']);
                }
                
                //set use of layout. updates both new and existing rel resources
                if ($value['resourceId']==$use_layout_id){
                    $questionnaireRelResource->setUseOfLayout(1);
                }
                else{
                    $questionnaireRelResource->setUseOfLayout(0);
                }
                
                //save
                $em->persist($questionnaireRelResource);
                $em->flush();
                
            }//end-if-else
         }//end-for-each
         
         
         //remove relresources from the table that are not in the list
        $result = $em->getRepository('WBQbankBundle:QuestionnaireModulesRelResources')->batchRemoveResources($module_id,$related_resources_id_arr);
         
         
        //update sources
        $related_sources=NULL;
        $related_sources_str = $request->request->get("sources");
        parse_str($related_sources_str, $related_sources);
        
         if (isset($related_sources['QuestionnaireEdit']['QuestionModuleRelSources']))
         {
            $related_sources=$related_sources['QuestionnaireEdit']['QuestionModuleRelSources'];
         }
         
         $related_sources_id_arr=array();//an array of relsources resourceID list

         
         foreach($related_sources as $key=>$value)
         {
                $related_sources_id_arr[]=$value['resourceId'];
                
                //get a reference to the related source if it exists
                $questionnaireRelSource = $em->getRepository("WBQbankBundle:QuestionnaireModulesRelSources")
                    ->findOneBy(["resourceId" => $value['resourceId'],"questModuleId"=>$module_id]);
                
                //create a new related source, if not exists
                if (empty($questionnaireRelSource)) {                    
                    $questionnaireRelSource = new QuestionnaireModulesRelSources();                    
                }
                
                //get the object references for resource and module
                $resource = $em->getRepository('WBQbankBundle:Resources')->find($value['resourceId']);
                $quest_module = $em->getRepository('WBQbankBundle:QuestionnaireModules')->find($module_id);

                $questionnaireRelSource->setQuestModuleId($quest_module);
                $questionnaireRelSource->setResourceId($resource);
                $questionnaireRelSource->setWeight($value['weight']);
                                
                //save
                $em->persist($questionnaireRelSource);
                $em->flush();                
         }//end-for-each
         
         
         //remove relsources from the table that are not in the list
        $result = $em->getRepository('WBQbankBundle:QuestionnaireModulesRelSources')->batchRemoveSources($module_id,$related_sources_id_arr); 
         
        return new Response("ok");
    }

    
    
    public function editQuestionnaireAction($id, Request $request)
    {
        $data = $request->request->all();
        $em = $this->getDoctrine()->getManager();

        // get questionnaire by id
        //$questionnaire = $em->getRepository('WBQbankBundle:QuestionnaireModules')->find($id);
        $questionnaire = QuestionnaireModulesRepository::getQuestionnaireDTOs($em, $id);

        if (!$questionnaire) {
            throw $this->createNotFoundException(
                'No concept found'
            );
        }

        $questions = QuestionnaireModulesRepository::getQuestionDTOs($em, $questionnaire->getId());
        foreach ($questions as $question) {
            if ($question->getClassificationId() != null) {
                $classification = $em->getRepository('WBQbankBundle:Classifications')->findOneById($question->getClassificationId());
                $question->setClassificationName($classification->getName());
            }
        }
        
        //get related resources
        $query = $em->createQueryBuilder();
        $query
            ->select('q')
            ->from('WBQbankBundle:QuestionnaireModulesRelResources', 'q')
            ->where('q.questModuleId = :id')
            ->setParameter('id', $id)
            ->orderBy('q.weight', 'ASC');
        $q = $query->getQuery();
        $questionModuleRelResources = $q->getResult();
        
        $resources = [];
        foreach ($questionModuleRelResources as $questRelResource) {
            $resourceModel = $questRelResource->getResourceId();
            $resource = new \stdClass();
            $resource->id = $resourceModel->getId();
            $resource->title = $resourceModel->getTitle();
            $resource->creator = $resourceModel->getCreator();
            $resource->pubDate = $resourceModel->getPubdate();
            $resource->weight = $questRelResource->getWeight();
            
            $resource->description = $resourceModel->getDescription();
            $resource->location = $resourceModel->getFileName();
            $resource->useOfLayout = $questRelResource->getUseOfLayout();
            if ($resource->location != null) {
                $filenameArray =explode("/",$resource->location);
                $filename = $filenameArray[count($filenameArray) -1];
                $extension = explode(".",$filename);
                $resource->fileType = end($extension);
            }
            $resources[] = $resource;
        }

        //get related sources
        $query = $em->createQueryBuilder();
        $query
            ->select('q')
            ->from('WBQbankBundle:QuestionnaireModulesRelSources', 'q')
            ->where('q.questModuleId = :id')
            ->setParameter('id', $id)
            ->orderBy('q.weight', 'ASC');
        $q = $query->getQuery();
        $questionModuleRelSources = $q->getResult();


        $sources = [];
        foreach ($questionModuleRelSources as $questRelSource) {
            $resourceModel = $questRelSource->getResourceId();
            $resource = new \stdClass();
            $resource->id = $resourceModel->getId();
            $resource->title = $resourceModel->getTitle();
            $resource->creator = $resourceModel->getCreator();
            $resource->pubDate = $resourceModel->getPubdate();
            $resource->weight = $questRelSource->getWeight();
            
            $resource->description = $resourceModel->getDescription();
            $resource->location = $resourceModel->getFileName();
            
            if ($resource->location != null) {
                $filenameArray =explode("/",$resource->location);
                $filename = $filenameArray[count($filenameArray) -1];
                $extension = explode(".",$filename);
                $resource->fileType = end($extension);
            }
            $sources[] = $resource;
        }
        
        // form
        $form = $this->createForm(new QuestionnairesEditType(), $questionnaire);
        
        /*
        echo '<pre>';
        \Doctrine\Common\Util\Debug::dump($form);
        die("");
*/
        
        $form->handleRequest($request);

        return $this->render('@WBQbank/QuestionnairesBack/editQuestionnaire.html.twig', array(
            'form' => $form->createView(),
            'questionnaireId' => $id,
            'questions' => $questions,
            'resources' => $resources,
            'sources'   => $sources,
            'visualRepFormatTypes' => new QuestionVisualRepresentationFormats()
        ));
    }

    public function publishUnpublishAction($id, $publish)
    {

        $em = $this->getDoctrine()->getManager();

        // get questionnaire by id
        $publish = (boolean)$publish;
        $questionnaire = $em->getRepository('WBQbankBundle:QuestionnaireModules')->findOneBy(["id" => $id]);

        $questionnaire->setPublished($publish);
        $em->flush();

        return new Response("ok");
    }

    public function publishUnpublishGroupAction($id, $publish)
    {

        $em = $this->getDoctrine()->getManager();

        // get questionnaire by id
        $publish = (boolean)$publish;
        $questionnaireGroup = $em->getRepository('WBQbankBundle:QuestionnaireGroups')->findOneBy(["id" => $id]);

        $questionnaireGroup->setPublished($publish);
        $em->flush();

        return new Response("ok");
    }

    public function deleteQuestionnaireAction($id)
    {
        // find questionnaire by id
        $em = $this->getDoctrine()->getManager();
        $questionnaire = $em->getRepository('WBQbankBundle:QuestionnaireModules')
            ->findOneById($id);

        if (!$questionnaire) {
            throw $this->createNotFoundException(
                'No Concept found'
            );
        }

        // delete questionnaire
        $em->remove($questionnaire);
        $em->flush();
        return new Response('ok');
    }

    /**
     * Delete group
     * and detach related questionnaire
     * onDelete: CASCADE
     */
    public function deleteQuestionnaireGroupAction($id)
    {
        // find group by id
        $em = $this->getDoctrine()->getManager();
        $questionnaireGroup = $em->getRepository('WBQbankBundle:QuestionnaireGroups')
            ->findOneById($id);

        if (!$questionnaireGroup) {
            throw $this->createNotFoundException(
                'No Group found'
            );
        }

        //find subgroups
        $subGroups = $em->getRepository('WBQbankBundle:QuestionnaireGroups')
            ->findByPid($id);

        // delete group if does not contain subgroups
        if (count($subGroups) == 0) {
            $em->remove($questionnaireGroup);
            $em->flush();
            return new Response('ok');
        } else {
            return new Response('Has subgroups');
        }
    }

    /**
     * Attach questionnaire to group after dragging
     */
    public function attachQuestionnaireToGroupAction($grpId, $nodeId)
    {
        // group object
        $group = $this->getDoctrine()
            ->getRepository('WBQbankBundle:QuestionnaireGroups')
            ->find($grpId);

        // questionnaire object
        $questionnaire = $this->getDoctrine()
            ->getRepository('WBQbankBundle:QuestionnaireModules')
            ->find($nodeId);

        // group/questionnaire reference
        $questionnaireGrpRef = new QuestionnaireGroupRelModules();
        $questionnaireGrpRef->setQuestGroupId($group);
        $questionnaireGrpRef->setQuestModuleId($questionnaire);
        $questionnaireGrpRef->setWeight(0);

        // avoid duplicate entry
        $validator = $this->get('validator');
        $errors = $validator->validate($questionnaireGrpRef);

        if (count($errors) > 0) {
            // reference already exists
            $errorsString = (string)$errors;
            return new Response($errorsString);
        } else {
            // write reference into db
            $em = $this->getDoctrine()->getManager();
            $em->persist($questionnaireGrpRef);
            $em->flush();
            return new Response('ok');
        }
    }

    public function deleteQuestionnaireFromGroupsAction($grpId, $nodeId)
    {
        // find Questionnaire Group by id
        $em = $this->getDoctrine()->getManager();
        $questionnaireGrpRef = $em->getRepository('WBQbankBundle:QuestionnaireGroupRelModules')
            ->findOneBy(
                array('questGroupId' => $grpId, 'questModuleId' => $nodeId)
            );

        if (!$questionnaireGrpRef) {
            return new Response('Not found');
        } else {
            // delete Questionnaire Group from db
            $em->remove($questionnaireGrpRef);
            $em->flush();

            return new Response('ok');
        }
    }

    public function moveQuestionnaireToGroupAction($grpId, $grpOldId, $nodeId)
    {
        // group object
        $group = $this->getDoctrine()
            ->getRepository('WBQbankBundle:QuestionnaireGroups')
            ->find($grpId);

        // questionnaire object
        $questionnaire = $this->getDoctrine()
            ->getRepository('WBQbankBundle:QuestionnaireModules')
            ->find($nodeId);

        // group/questionnaire reference
        $questionnaireGrpRef = $this->getDoctrine()
            ->getRepository('WBQbankBundle:QuestionnaireGroupRelModules')
            ->findOneBy(
                array('questGroupId' => $grpOldId, 'questModuleId' => $nodeId)
            );

        $questionnaireGrpRef->setIndGroupId($group);

        // avoid duplicate entry
        $validator = $this->get('validator');
        $errors = $validator->validate($questionnaireGrpRef);

        if (count($errors) > 0) {
            // reference already exists
            $errorsString = (string)$errors;
            return new Response($errorsString);
        } else if (is_numeric($grpId) && is_numeric($grpOldId) && is_numeric($nodeId)) {
            // write reference into db
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return new Response('ok');
        } else {
            return new Response('Missing argument');
        }
    }

    /**
     * Update parent id for a group
     */
    public function updateGroupPidAction($id, $pid)
    {
        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('WBQbankBundle:QuestionnaireGroups')
            ->findOneById($id);

        if (!$group) {
            throw $this->createNotFoundException(
                'No group found'
            );
        }

        $group->setPid($pid);
        $em->flush();

        return new Response('ok');
    }

    /**
     * Questionnaire breadcrumbs
     * If questionnaire belongs to more than one - show all breadcrumbs
     */
    public function questionnaireBreadcrumbsAction($questId, $public)
    {
        // first parent groups
        $em = $this->getDoctrine()->getManager();
        $relGroups = $em->getRepository('WBQbankBundle:QuestionnaireGroupRelModules')
            ->findByQuestModuleId($questId);

        // make array of parent groups for each first parent group
        $parentGroups = array();

        foreach ($relGroups as $relGroup) {

            $this->get('helpers')->resetParentGroups();

            $group = $em->getRepository('WBQbankBundle:QuestionnaireGroups')
                ->find($relGroup->getQuestGroupId());

            $parentGroups[] = array(
                'id' => $group->getId(),
                'name' => $group->getName(),
                'parents' => $this->get('helpers')->getParentGroups($group->getPid(), 'WBQbankBundle:QuestionnaireGroups'),
            );
        }

        // questionnaire
        $questionnaire = $em->getRepository('WBQbankBundle:QuestionnaireModules')
            ->find($questId);

        return $this->render('WBQbankBundle:QuestionnairesBack:questionnaireBreadcrumbs.html.twig', array(
            'parentGroups' => $parentGroups,
            'questName' => $questionnaire->getName(),
            'questId' => $questionnaire->getId(),
            'public' => $public
        ));
    }

    /**
     * Update weight of all group questionnaire relations
     */
    public function updateGrpRefWeightAction($groupId, Request $request)
    {
        $weights = $request->request->get('weights');
        $em = $this->getDoctrine()->getManager();
        $grpRefs = $em->getRepository('WBQbankBundle:QuestionnaireGroupRelModules')->findByQuestGroupId($groupId);
        foreach ($grpRefs as $grpRef) {
            $grpRef->setWeight($weights[$grpRef->getQuestModuleId()->getId()]);
        }

        $em->flush();
        return new Response('ok');
    }


    /**
     * Update weight of all questionnaire groups inside of specific group
     */
    public function updateGrpWeightAction($pid, Request $request)
    {
        $weights = $request->request->get('weights');
        $em = $this->getDoctrine()->getManager();
        $grpRefs = $em->getRepository('WBQbankBundle:QuestionnaireGroups')->findByPid($pid);
        foreach ($grpRefs as $grpRef) {
            $grpRef->setWeight($weights[$grpRef->getId()]);
        }

        $em->flush();
        return new Response('ok');
    }

    /**
     * Group breadcrumb
     * array of parent groups
     */
    public function questionnaireGroupBreadcrumbAction($grpId, $public)
    {
        $this->get('helpers')->resetParentGroups();

        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('WBQbankBundle:QuestionnaireGroups')
            ->find($grpId);

        $parents = $this->get('helpers')->getParentGroups($group->getPid(), 'WBQbankBundle:QuestionnaireGroups');

        return $this->render('WBQbankBundle:QuestionnairesBack:questionnaireGroupBreadcrumb.html.twig', array(
            'group' => $group,
            'parentGroups' => $parents,
            'public' => $public
        ));
    }

    /**
     * Groups by parent id
     */
    public function questionnaireGroupsListAction($pid)
    {
        $questGroupsRepo = $this->getDoctrine()
            ->getRepository('WBQbankBundle:QuestionnaireGroups');

        $questGroups = $questGroupsRepo->findByPid($pid);

        return $this->render('WBQbankBundle:QuestionnairesBack:questionnaireGroupsList.html.twig', array(
            'questGroups' => $questGroups,
            'pid' => $pid
        ));
    }

    public function getClassificationCodesAction($questionIndex, $classificationId, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $questionCodes = $em->getRepository('WBQbankBundle:ClassificationCodes')->findByClassificationId($classificationId);
        return $this->render('@WBQbank/QuestionnairesBack/partials/classificationCodesPartial1.html.twig', array(
            'questionCodes' => $questionCodes,
            'questionIndex' => $questionIndex
        ));

    }

    public function getClassificationCodesDTOAction($classificationId)
    {
        $em = $this->getDoctrine()->getManager();
        $questionCodes = $em->getRepository('WBQbankBundle:ClassificationCodes')->findByClassificationId($classificationId);
        $questionCodesDTO = [];
        foreach ($questionCodes as $questionCode) {
            $questionCodeDTO = [];
            $questionCodeDTO["id"] = $questionCode->getId();
            $questionCodeDTO["label"] = $questionCode->getLabel();
            $questionCodeDTO["value"] = $questionCode->getValue();
            $questionCodesDTO[] = (object)$questionCodeDTO;
        }
        $json = json_encode($questionCodesDTO);

        $response = new Response($json);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    public function uploadResourceFilesAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $dir = $this->container->getParameter('resources-upload-path');
        $files = $request->files->all();
        foreach ($files as $key => $file) {
            $resourceId = $key;
            if (is_object($file)) {
                //$resourceModel = $em->getRepository("WBQbankBundle:QuestionnaireModuleResources")->findOneBy(["id" => $resourceId]);
                $resource = $em->getRepository('WBQbankBundle:Resources')->find($resourceId);

                $filename = time() . $file->getClientOriginalName();
                $file->move($dir, $filename);
                $location = $dir . $filename;
                //$resource->setLocation($location);
                $resource->setFilename($location);
                //$fileNameArray = explode(".", $filename);
                //$extension = end($fileNameArray);
                //$resourceModel->setFileType($extension);
                // == "pdf"
                $em->flush();
            }
        }
        return new Response('Ok');

    }

    public function saveQuestionModelAction(Request $request)
    {
        //$requestStrings = explode("&", urldecode($request->getContent()));
        
        $request_data=null;
        parse_str($request->getContent(), $request_data);
        
        $locale=$request_data['_locale'];
        $question=$request_data['question'];
        
        $questionDTO=json_decode($question);
        
        //$questionStrings = explode("=", $requestStrings[1]);
       // $questionDTO = json_decode($questionStrings[1]);
       
        $em = $this->getDoctrine()->getManager();

        $questionnaire = $em->getRepository('WBQbankBundle:QuestionnaireModules')->find($questionDTO->questionnaireId);

        if ($questionDTO->id != null && $questionDTO->id != "") {
            $questionModel = $em->getRepository('WBQbankBundle:QuestionnaireModuleQuestions')->find($questionDTO->id);
        } else {
            $questionModel = new QuestionnaireModuleQuestions();
        }
        
        // parsing DTO to Model
        $questionModel->setName($questionDTO->name);
        $questionModel->setDescription($questionDTO->description);
        $questionModel->setLiteralText($questionDTO->literalText);
        $questionModel->setPostText($questionDTO->postText);
        $questionModel->setPreText($questionDTO->preText);
        $questionModel->setInstructions($questionDTO->instructions);
        $questionModel->setNotes($questionDTO->notes);
        $questionModel->setVisualRepFormat($questionDTO->visualRepFormat);
        $questionModel->setQuestModuleId($questionnaire);
        
        if ($questionModel->getVisualRepFormat() == 3) {
            if ($questionDTO->classificationId != null && $questionDTO->classificationId != "") {
                if ($questionDTO->classificationId > 0) {
                    $classificationModel = $em->getRepository('WBQbankBundle:Classifications')->findOneById($questionDTO->classificationId);
                    $questionModel->setClassificationId($classificationModel);
                } else { //remove classification if there's existing one
                    $questionModel->setClassificationId(null);
                }
            }
        } else {
            if (isset($questionDTO->valRepFormat)) {
                $questionModel->setValRepFormat($questionDTO->valRepFormat);
            }
            //removing classifications if it exists
            if ($questionModel->getClassificationId() != null) {
                $questionModel->setClassificationId(null);
            }
        }

        //check if updating or creating new question. UPDATE:
        if ($questionDTO->id != null && $questionDTO->id != "") {
            $em->flush();
            if ($questionModel->getVisualRepFormat() == 3 && is_array($questionDTO->classificationCodes)
                //&& count($questionDTO->classificationCodes) > 0
                ) {

                $classificationCodesIds = [];
                foreach ($questionDTO->classificationCodes as $classificationCode) {
                    $classificationCodesIds[] = $classificationCode->id;
                    $classificationCodeQuestionRelModel = $em->getRepository('WBQbankBundle:QuestionsRelClassifications')->findBy(["classificationCodeId" => $classificationCode->id,
                        "questionId" => $questionDTO->id]);
                    if ($classificationCodeQuestionRelModel != null && count($classificationCodeQuestionRelModel) > 0) {//if that code already exists
                        $classificationCodeQuestionRelModel[0]->setSkipValue($classificationCode->skipValue);
                        $em->flush();
                    } else {
                        $CCQRelModel = new QuestionsRelClassifications();
                        $CCQRelModel->setQuestionId($questionModel);
                        $classificationCodeModel = $em->getRepository('WBQbankBundle:ClassificationCodes')->findOneById($classificationCode->id);
                        $CCQRelModel->setClassificationCodeId($classificationCodeModel);
                        $CCQRelModel->setSkipValue($classificationCode->skipValue);
                        $em->persist($CCQRelModel);
                        $em->flush();
                    }
                }
                //removing codes if they are changed
                //WRITE QUERY WHERE QUESTION ID = QuestionDTO->id && classification_code_id is not in []$classificationCodesIds
                $classificationCodeQuestionRelModels = $em->getRepository('WBQbankBundle:QuestionsRelClassifications')->findBy(["questionId" => $questionDTO->id]);
                foreach ($classificationCodeQuestionRelModels as $classificationCodeQuestionRelModel) {
                    if (!in_array($classificationCodeQuestionRelModel->getClassificationCodeId()->getId(), $classificationCodesIds)) {
                        $em->remove($classificationCodeQuestionRelModel);
                        $em->flush();
                    }
                }
            }

        } else { // creating new object
            $em->persist($questionModel);
            $em->flush();
            $questions = $em->getRepository("WBQbankBundle:QuestionnaireModuleQuestions")->findBy(["questModuleId" => $questionModel->getQuestModuleId()]);
            if (count($questions) > 1) {
                $questionModel->setWeight($questions[count($questions) - 2]->getWeight() + 1);
            } else {
                $questionModel->setWeight(1);
            }

            $em->flush();

            if (isset($questionDTO->classificationCodes) && $questionDTO->classificationCodes != null && count($questionDTO->classificationCodes) > 0) {
                foreach ($questionDTO->classificationCodes as $classificationCode) {
                    $CCQRelModel = new QuestionsRelClassifications();
                    $CCQRelModel->setQuestionId($questionModel);
                    $classificationCodeModel = $em->getRepository('WBQbankBundle:ClassificationCodes')->findOneById($classificationCode->id);
                    $CCQRelModel->setClassificationCodeId($classificationCodeModel);
                    $CCQRelModel->setSkipValue($classificationCode->skipValue);
                    $em->persist($CCQRelModel);
                    $em->flush();
                }
            }
            else
            {
                //remove 
            }
        }
        return new Response($questionModel->getId());
    }


    public function getQuestionModelAction($questionId)
    {
        $encoders = array(new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());
        $normalizers[0]->setIgnoredAttributes(array('questModuleId', 'questionsRelClassifications', 'classificationId', "owner", "em", "questionId"));

        $serializer = new Serializer($normalizers, $encoders);

        $em = $this->getDoctrine()->getManager();

        $questionModel = $em->getRepository('WBQbankBundle:QuestionnaireModuleQuestions')
            ->findOneById($questionId);

        $questionModelJSON = $serializer->serialize($questionModel, 'json');


        //$questionRelClassifications = $em->getRepository('WBQbankBundle:QuestionsRelClassifications')->findBy(array('questionId' => $questionId));

        $questionObj = json_decode($questionModelJSON);
        $questionObj->visualRepFormat = $questionModel->getVisualRepFormat();

        if ($questionModel->getVisualRepFormat() == 3) {

            $classificationCodes = [];

            /* Displaying classification codes only if they have skip value -> removed by email issue request
            foreach ($questionRelClassifications as $questionClassification) {
                $id = $questionClassification->getClassificationCodeId()->getId();
                $classificationCode = ClassificationCodesRepository::getClassificationCodesDTO($em, $id);
                $classificationCode->question_id = $questionModel->getId();
                $classificationCode->skipValue = QuestionsRelClassificationsRepository::getSkipValue($em, $classificationCode->id, $classificationCode->question_id);
                $classificationCodes [] = $classificationCode;
            }
            */
            if ($questionModel->getClassificationId() != null) {

                $classification = $em->getRepository('WBQbankBundle:Classifications')->findOneById($questionModel->getClassificationId()->getId());
                $classificationCodeModels = $em->getRepository('WBQbankBundle:ClassificationCodes')->findBy(["classificationId" => $classification->getId()]);
                foreach ($classificationCodeModels as $classificationCodeModel) {
                    $classificationCode = new ClassificationCodeDTO($classificationCodeModel->getId(), $classificationCodeModel->getLabel(), $classificationCodeModel->getValue());
                    $skipValue = $em->getRepository('WBQbankBundle:QuestionsRelClassifications')->findOneBy(["classificationCodeId" => $classificationCodeModel->getId(),
                        "questionId" => $questionModel->getId()]);
                    if ($skipValue != null) {
                        $classificationCode->skipValue = $skipValue->getSkipValue();
                    } else {
                        $classificationCode->skipValue = "";
                    }
                    $classificationCodes[] = $classificationCode;
                }
                $questionObj->classificationName = $classification->getName();
                $questionObj->classificationId = $classification->getId();
                $questionObj->classificationCodes = $classificationCodes;
            }
        } else {
            $questionObj->valRepFormat = $questionModel->getValRepFormat();
        }

        $json = json_encode($questionObj);

        $response = new Response($json);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    public
    function visualRepInfoAction($visualRepFormat, $valRepFormat)
    {
        switch ($visualRepFormat) {
            case QuestionVisualRepresentationFormats::Numeric:
                $info = array(
                    "val_rep_format" => $valRepFormat,
                    "numeric" => explode(".", $valRepFormat)
                );
                break;
            case QuestionVisualRepresentationFormats::Text:
                $info = $valRepFormat;
                break;
            default:
                $info = false;
                break;
        }

        return $this->render('@WBQbank/QuestionnairesBack/partials/valueRepInfoNumber.html.twig', array(
            "visualRepFormat" => $visualRepFormat,
            "info" => $info
        ));
    }

    private function cloneQuestionnaireGroup($idForCloning, $em = null, $parentGroupPid = null)
    {
        if ($em != null) {
            $em = $this->getDoctrine()->getManager();
        }
        if ($idForCloning) {

            $groupForCloning = $em->getRepository('WBQbankBundle:QuestionnaireGroups')
                ->findOneById($idForCloning);
            $questionnaireGroup = clone $groupForCloning;
            $questionnaireGroup->setName($questionnaireGroup->getName() . " - copy");

            foreach ($groupForCloning->getQuestionnaireGroupRelModules() as $groupRel) {
                $clonedQuestionnaire = ($this->cloneQuestionnaire($groupRel->getQuestModuleId(), $em, true));
                $em->persist($clonedQuestionnaire);
                $newGroupRel = clone $groupRel;
                $newGroupRel->setQuestGroupId($questionnaireGroup);
                $newGroupRel->setQuestModuleId($clonedQuestionnaire);//group
                $em->persist($newGroupRel);
                $questionnaireGroup->addQuestionnaireGroupRelModule($newGroupRel);
            }

            foreach ($groupForCloning->getQuestionnaireGroupRelCustodians() as $groupRel) {
                $newGroupRel = clone $groupRel;
                $newGroupRel->setQuestGroupId($questionnaireGroup);
                $newGroupRel->setOrganizationId($groupRel->getOrganizationId());
                $em->persist($newGroupRel);
                $questionnaireGroup->addQuestionnaireGroupRelCustodian($newGroupRel);
            }
            foreach ($groupForCloning->getQuestionnaireGroupRelResources() as $groupRel) {
                $newGroupRel = clone $groupRel;
                $newGroupRel->setQuestGroupId($questionnaireGroup);
                $newGroupRel->setResourceId($groupRel->getResourceId());
                $em->persist($newGroupRel);
                $questionnaireGroup->addQuestionnaireGroupRelResource($newGroupRel);
            }
            if ($parentGroupPid) {
                $questionnaireGroup->setPid($parentGroupPid);
            }

        }
        $em->persist($questionnaireGroup);
        $em->flush();
        $subgroups = $em->getRepository('WBQbankBundle:QuestionnaireGroups')->findByPid($idForCloning);
        foreach ($subgroups as $subgroup) {
            $this->cloneQuestionnaireGroup($subgroup, $em, $questionnaireGroup->getId());
        }
    }

    private
    function cloneQuestionnaire($idForCloning, $em = null, $cloningGroup = null)
    {
        if ($em == null) {
            $em = $this->getDoctrine()->getManager();
        }

        $questionnaireForCloning = $em->getRepository('WBQbankBundle:QuestionnaireModules')->findOneById($idForCloning);

        $questionnaire = clone $questionnaireForCloning;
        $questionnaire->setName($questionnaire->getName() . " - copy");

        if ($cloningGroup == null) {
            foreach ($questionnaireForCloning->getQuestionnaireGroupRelModules() as $groupRel) {
                $newGroupRel = clone $groupRel;
                $newGroupRel->setQuestModuleId($questionnaire);
                $questionnaire->addQuestionnaireGroupRelModule($newGroupRel);
            }
        }
        foreach ($questionnaireForCloning->getQuestionnaireModuleQuestions() as $question) {
            $newQuestion = clone $question;
            $newQuestion->setQuestModuleId($questionnaire);
            $questionnaire->addQuestionnaireModuleQuestion($newQuestion);
        }
        foreach ($questionnaireForCloning->getQuestionnaireModuleResources() as $resource) {
            $newResource = clone $resource;
            $newResource->setQuestModuleId($questionnaire);
            $questionnaire->addQuestionnaireModuleResource($newResource);
        }
        return $questionnaire;
    }

    public
    function sort($a, $b)
    {
        if ($a->getClassificationCodeId()->getWeight() < $b->getClassificationCodeId()->getWeight()) {
            return -1;
        } else {
            return 1;
        }
    }
}



