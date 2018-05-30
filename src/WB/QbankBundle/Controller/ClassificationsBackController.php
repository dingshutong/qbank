<?php

namespace WB\QbankBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WB\QbankBundle\Entity\ClassificationCodes;
use WB\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WB\QbankBundle\Entity\Classifications;
use WB\QbankBundle\Entity\ClassificationGroups;
use WB\QbankBundle\Entity\ClassificationGrpRef;
use WB\QbankBundle\Form\Type\ClassificationGroupsType;
use WB\QbankBundle\Form\Type\ClassificationsEditType;
use WB\QbankBundle\Enums\ActiveButtons;


class ClassificationsBackController extends Controller
{
    public function classificationsAction()
    {
        return $this->render(
            '@WBQbank/ClassificationsBack/classifications.html.twig',
            array(
                'active_button' => ActiveButtons::AdminClassifications
            )
        );
    }

    public function addClassificationAction(Request $request, $idForCloning)
    {

        $em = $this->getDoctrine()->getManager();

        if ($idForCloning) {
            $classificationForCloning = $em->getRepository('WBQbankBundle:Classifications')->findOneById($idForCloning);

            $classification = clone $classificationForCloning;
            $classification->setName($classification->getName() . " - copy");

            foreach ($classificationForCloning->getClassificationGrpRef() as $groupRel) {
                $newGroupRel = clone $groupRel;
                $newGroupRel->setClassificationId($classification);
                $classification->addClassificationGrpRef($newGroupRel);
            }
            foreach ($classificationForCloning->getClassificationCodes() as $code) {
                $newCode = clone $code;
                $newCode->setClassificationId($classification);
                $classification->addClassificationCode($newCode);
            }
            foreach ($classificationForCloning->getClassificationRelTerms() as $termRel) {
                $newTermRel = clone $termRel;
                $newTermRel->setClassificationId($classification);
                $classification->addClassificationRelTerm($newTermRel);
            }
            foreach ($classificationForCloning->getClassificationRelCustodians() as $custodianRel) {
                $newCustodianRel = clone $custodianRel;
                $newCustodianRel->setClassificationId($classification);
                $classification->addClassificationRelCustodian($newCustodianRel);
            }
            foreach ($classificationForCloning->getClassificationRelResources() as $resourceRel) {
                $newResourceRel = clone $resourceRel;
                $newResourceRel->setClassificationId($classification);
                $classification->addClassificationRelResource($newResourceRel);
            }
        } else {
            $classification = new Classifications();

            $name = $this->get('request')->request->get('name');
            $grpId = $this->get('request')->request->get('grpId');

            // set reference to group
            if ($grpId != 0) {

                // Classification group object
                $classificationGrp = $em->getRepository('WBQbankBundle:ClassificationGroups')
                    ->find($grpId);

                if ($classificationGrp) {
                    $classificationGrpRef = new ClassificationGrpRef();
                    $classificationGrpRef->setClassificationGroupId($classificationGrp);
                    $classificationGrpRef->setClassificationId($classification);
                    $classificationGrpRef->setWeight(0);
                    $em->persist($classificationGrpRef);
                }
            }

            $classification->setName($name);
            $classification->setWeight(0);
        }

        $em->persist($classification);
        $em->flush();

        // return new classification id
        return new Response($classification->getId());
    }

    public function classificationGroupsAction($publishedOnly, $search)
    {
        $showPublishedOnly = ($publishedOnly == 'true') ? true : false;

        $grpTree = $this->get('helpers')->makeClassificationTree($showPublishedOnly, $search);

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
        for ( $i = count($groups)-1;$i>-1; $i--) {
            if (!empty($groups[$i]["items"])) {
                usort($groups[$i]["items"], function ($a, $b) {
                    return  strcasecmp($a->getName(), $b->getName());
                });
               //$groups[$i]["items"] = [];
            }
        }
        usort($groups, function ($a, $b) {
            return strcasecmp($a["name"], $b["name"]);
        });
        return $this->render('WBQbankBundle:ClassificationsBack:classificationGroups.html.twig', array(
            'groups' => $groups,
            'countGroups' => $countGroups
        ));
    }

    public function classificationRepositoryAction($filterAssigned, $filterPublished, $sort, $search, Request $request)
    {

        $excludedIds = $request->request->get('excludedIds');

        $repository = $this->getDoctrine()->getRepository("WBQbankBundle:Classifications");

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

        $classifications = $repository->searchClassifications($paramAssigned, $paramPublished, $search, $excludedIds, $sort);

        return $this->render('@WBQbank/ClassificationsBack/classificationRepository.html.twig', array(
            'classifications' => $classifications,
            'countClassifications' => count($classifications),
            'active_button' => ActiveButtons::AdminClassifications
        ));

    }

    public function editClassificationGroupAction($id, Request $request)
    {

        // get group by id
        $classificationGroup = $this->getDoctrine()->getManager()
            ->getRepository('WBQbankBundle:ClassificationGroups')
            ->find($id);

        if (!$classificationGroup) {
            throw $this->createNotFoundException(
                'No group found'
            );
        }

        // form
        $form = $this->createForm(new ClassificationGroupsType(), $classificationGroup);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return new Response('ok');
        }

        return $this->render("@WBQbank/ClassificationsBack/editClassificationGroup.html.twig", array(
            "form" => $form->createView(),
            "grpId" => $id
        ));
    }

    public function addClassificationGroupAction(Request $request)
    {
        $classificationGroup = new ClassificationGroups();

        $name = $this->get('request')->request->get('name');
        $pid = $this->get('request')->request->get('pid');

        $em = $this->getDoctrine()->getManager();
        $classificationGroup->setName($name);
        $classificationGroup->setPid($pid);
        $classificationGroup->setPublished(0);
        $em->persist($classificationGroup);
        $em->flush();

        // return new group id
        return new Response($classificationGroup->getId());
    }
    
    
    //update the weight column
    private function updateWeight(&$data)
    {
        
        $weight=0;
        foreach($data as $key=>$value)
        {
            $data[$key]['weight']=$weight++;
        }
        
        return $data;
    }
    

    public function editClassificationAction($id, Request $request)
    {
     
      $request_data=$request->request->get("classificationsEdit");
        
        //update weights for related items
        if ($request_data){
        
            //weight items
            $weight_items=array(
                "classificationRelCustodians",
                "classificationRelResources",
                "classificationRelSources",
                "classificationRelTerms",
                "classificationCodes"
            );
            
            //update weights
            foreach($weight_items as $item){
                if (isset($request_data[$item])){
                    $this->updateWeight($request_data[$item]);
                }    
            }
            
            //update request array
            $request->request->set("classificationsEdit",$request_data);
        }
        
        // get classification by id
        $classification = $this->getDoctrine()->getManager()
            ->getRepository('WBQbankBundle:Classifications')
            ->find($id);

        if (!$classification) {
            throw $this->createNotFoundException(
                'No classification found'
            );
        }

        // form
        $form = $this->createForm(new ClassificationsEditType(), $classification);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            
            $em = $this->getDoctrine()->getManager();

            foreach ($classification->getClassificationCodes() as $code) {
                
                if ($code->getLabel() != '') {
                    $code->setClassificationId($classification);
                } else {
                    $em->remove($code);
                }
            }

            foreach ($classification->getClassificationRelCustodians() as $custodian) {
                if ($custodian->getOrganizationId() == null) {
                    $em->remove($custodian);
                } else {
                    $custodian->setClassificationId($classification);
                }
            }

            foreach ($classification->getClassificationRelTerms() as $concept) {
                if ($concept->getTermId() == null) {
                    $em->remove($concept);
                } else {
                    $concept->setClassificationId($classification);
                }
            }

            foreach ($classification->getClassificationRelResources() as $resource) {
                if ($resource->getResourceId() == null) {
                    $em->remove($resource);
                } else {
                    $resource->setClassificationId($classification);
                }
            }
            
            foreach ($classification->getClassificationRelSources() as $source) {
                if ($source->getResourceId() == null) {
                    $em->remove($source);
                } else {
                    $source->setClassificationId($classification);
                }
            }

            $em->flush();

            return new Response('ok');
        }

        return $this->render('@WBQbank/ClassificationsBack/editClassification.html.twig', array(
            'form' => $form->createView(),
            'classificationId' => $id
        ));
    }

    public function deleteClassificationAction($id)
    {
        // find classification by id
        $em = $this->getDoctrine()->getManager();
        $classification = $em->getRepository('WBQbankBundle:Classifications')
            ->findOneById($id);

        if (!$classification) {
            throw $this->createNotFoundException(
                'No Classification found'
            );
        }
                
        //set classification references in questionnaire_module_questions to null
        $em->getRepository("WBQbankBundle:QuestionnaireModuleQuestions")
            ->batchRemoveQuestionClassifications($id);
        
            
        // delete classification
        $em->remove($classification);
        $em->flush();
        return new Response('ok');
    }

    /**
     * Delete group
     * and detach related classifications
     * onDelete: CASCADE
     */
    public function deleteClassificationGroupAction($id)
    {
        // find group by id
        $em = $this->getDoctrine()->getManager();
        $classificationGroup = $em->getRepository('WBQbankBundle:ClassificationGroups')
            ->findOneById($id);

        if (!$classificationGroup) {
            throw $this->createNotFoundException(
                'No Group found'
            );
        }

        //find subgroups
        $subGroups = $em->getRepository('WBQbankBundle:ClassificationGroups')
            ->findByPid($id);

        // delete group if does not contain subgroups
        if (count($subGroups) == 0) {
            $em->remove($classificationGroup);
            $em->flush();
            return new Response('ok');
        } else {
            return new Response('Has subgroups');
        }
    }

    /**
     * Attach classification to group after dragging
     */
    public function attachClassificationToGroupAction($grpId, $nodeId)
    {
        if ($grpId > 0) {

            // group object
            $group = $this->getDoctrine()
                ->getRepository('WBQbankBundle:ClassificationGroups')
                ->find($grpId);

            // classification object
            $classification = $this->getDoctrine()
                ->getRepository('WBQbankBundle:Classifications')
                ->find($nodeId);

            // group/classification reference
            $classificationGrpRef = new ClassificationGrpRef();
            $classificationGrpRef->setClassificationGroupId($group);
            $classificationGrpRef->setClassificationId($classification);
            $classificationGrpRef->setWeight(0);

            // avoid duplicate entry
            $validator = $this->get('validator');
            $errors = $validator->validate($classificationGrpRef);

            if (count($errors) > 0) {
                // reference already exists
                $errorsString = (string)$errors;
                return new Response($errorsString);
            } else {
                // write reference into db
                $em = $this->getDoctrine()->getManager();
                $em->persist($classificationGrpRef);
                $em->flush();
                return new Response('ok');
            }
        } else {
            return new Response('0');
        }
    }

    public function deleteClassificationFromGroupsAction($grpId, $nodeId)
    {
        // find Classification Group by id
        $em = $this->getDoctrine()->getManager();
        $classificationGrpRef = $em->getRepository('WBQbankBundle:ClassificationGrpRef')
            ->findOneBy(
                array('classificationGroupId' => $grpId, 'classificationId' => $nodeId)
            );

        if (!$classificationGrpRef) {
            return new Response('Not found');
        } else {
            // delete Classification Group from db
            $em->remove($classificationGrpRef);
            $em->flush();

            return new Response('ok');
        }
    }

    public function moveClassificationToGroupAction($grpId, $grpOldId, $nodeId)
    {
        // group object
        $group = $this->getDoctrine()
            ->getRepository('WBQbankBundle:ClassificationGroups')
            ->find($grpId);

        // classification object
        $classification = $this->getDoctrine()
            ->getRepository('WBQbankBundle:Classifications')
            ->find($nodeId);

        // group/classification reference
        $classificationGrpRef = $this->getDoctrine()
            ->getRepository('WBQbankBundle:ClassificationGrpRef')
            ->findOneBy(
                array('classificationGroupId' => $grpOldId, 'classificationId' => $nodeId)
            );

        $classificationGrpRef->setClassificationGroupId($group);

        // avoid duplicate entry
        $validator = $this->get('validator');
        $errors = $validator->validate($classificationGrpRef);

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
        $group = $em->getRepository('WBQbankBundle:ClassificationGroups')
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
     * Update weight of all group classification relations
     */
    public function updateGrpRefWeightAction($groupId, Request $request)
    {
        $weights = $request->request->get('weights');
        $em = $this->getDoctrine()->getManager();
        $grpRefs = $em->getRepository('WBQbankBundle:ClassificationGrpRef')->findByClassificationGroupId($groupId);
        foreach ($grpRefs as $grpRef) {
            $grpRef->setWeight($weights[$grpRef->getClassificationId()->getId()]);
        }

        $em->flush();
        return new Response('ok');
    }


    /**
     * Update weight of all classification groups inside of specific group
     */
    public function updateGrpWeightAction($pid, Request $request)
    {
        $weights = $request->request->get('weights');
        $em = $this->getDoctrine()->getManager();
        $grpRefs = $em->getRepository('WBQbankBundle:ClassificationGroups')->findByPid($pid);
        foreach ($grpRefs as $grpRef) {
            $grpRef->setWeight($weights[$grpRef->getId()]);
        }

        $em->flush();
        return new Response('ok');
    }


    /**
     * Classification breadcrumbs
     * If classification belongs to more than one - show all breadcrumbs
     */
    public function classificationBreadcrumbsAction($classId, $public)
    {
        // first parent groups
        $em = $this->getDoctrine()->getManager();
        $relGroups = $em->getRepository('WBQbankBundle:ClassificationGrpRef')
            ->findByClassificationId($classId);

        // make array of parent groups for each first parent group
        $parentGroups = array();

        foreach ($relGroups as $relGroup) {

            $this->get('helpers')->resetParentGroups();

            $group = $em->getRepository('WBQbankBundle:ClassificationGroups')
                ->find($relGroup->getClassificationGroupId());

            $parentGroups[] = array(
                'id' => $group->getId(),
                'name' => $group->getName(),
                'parents' => $this->get('helpers')->getParentGroups($group->getPid(), 'WBQbankBundle:ClassificationGroups'),
            );
        }

        // classification
        $classification = $em->getRepository('WBQbankBundle:Classifications')
            ->find($classId);

        return $this->render('WBQbankBundle:ClassificationsBack:classificationBreadcrumbs.html.twig', array(
            'parentGroups' => $parentGroups,
            'className' => $classification->getName(),
            'classId' => $classification->getId(),
            'public' => $public
        ));
    }

    /**
     * Group breadcrumb
     * array of parent groups
     */
    public function classificationGroupBreadcrumbAction($grpId, $public)
    {
        $this->get('helpers')->resetParentGroups();

        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('WBQbankBundle:ClassificationGroups')
            ->find($grpId);

        $parents = $this->get('helpers')->getParentGroups($group->getPid(), 'WBQbankBundle:ClassificationGroups');

        return $this->render('WBQbankBundle:ClassificationsBack:classificationGroupBreadcrumb.html.twig', array(
            'group' => $group,
            'parentGroups' => $parents,
            'public' => $public
        ));
    }

    /**
     * Groups by parent id
     */
    public function classificationGroupsListAction($pid)
    {
        $classGroupsRepo = $this->getDoctrine()
            ->getRepository('WBQbankBundle:ClassificationGroups');

        $classGroups = $classGroupsRepo->findByPid($pid);

        return $this->render('WBQbankBundle:ClassificationsBack:classificationGroupsList.html.twig', array(
            'classGroups' => $classGroups,
            'pid' => $pid
        ));
    }

    public function publishUnpublishAction($id, $publish)
    {

        $em = $this->getDoctrine()->getManager();
        $publish = (boolean)$publish;
        $entity = $em->getRepository('WBQbankBundle:Classifications')->findOneBy(["id" => $id]);

        $entity->setPublished($publish);
        $em->flush();

        return new Response("ok");

    }

    public function publishUnpublishGroupAction($id, $publish)
    {

        $em = $this->getDoctrine()->getManager();
        $publish = (boolean)$publish;
        $entity = $em->getRepository('WBQbankBundle:ClassificationGroups')->findOneBy(["id" => $id]);

        $entity->setPublished($publish);
        $em->flush();

        return new Response("ok");
    }
    
    
    public function editClassificationCode()
    {
        return new Response ("edit classification code");
    }


}
