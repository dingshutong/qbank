<?php

namespace WB\QbankBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WB\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WB\QbankBundle\Entity\Terms;
use WB\QbankBundle\Entity\TermGroups;
use WB\QbankBundle\Entity\TermGrpRef;
use WB\QbankBundle\Form\Type\ConceptGroupsType;
use WB\QbankBundle\Form\Type\ConceptsEditType;
use WB\QbankBundle\Form\Type\ConceptsType;
use WB\QbankBundle\Enums\ActiveButtons;


class ConceptsBackController extends Controller
{
    public function conceptsAction()
    {
        return $this->render(
            '@WBQbank/ConceptsBack/concepts.html.twig',
            array(
                'active_button' => ActiveButtons::AdminConcepts
            )
        );
    }

    public function addConceptAction(Request $request)
    {
        $concept = new Terms();

        $name = $this->get('request')->request->get('name');
        $grpId = $this->get('request')->request->get('grpId');

        $em = $this->getDoctrine()->getManager();

        // set reference to group
        if ($grpId != 0) {

            // Concept group object
            $termGrp = $em->getRepository('WBQbankBundle:TermGroups')
                ->find($grpId);

            if ($termGrp) {
                $termGrpRef = new TermGrpRef();
                $termGrpRef->setTermGroupId($termGrp);
                $termGrpRef->setTermId($concept);
                $termGrpRef->setWeight(0);
                $em->persist($termGrpRef);
            }
        }

        $concept->setName($name);
        $concept->setWeight(0);

        $em->persist($concept);

        $em->flush();

        // return new concept id
        return new Response($concept->getId());
    }

    public function conceptGroupsAction($publishedOnly, $search, Request $request)
    {
        //show empty groups or not?
        $showEmptryGroups=intval($request->query->get('show_empty_groups'));//expects 1 or 0
        
        $showPublishedOnly = ($publishedOnly == 'true') ? true : false;

        $conceptGroupsRepository = $this->getDoctrine()
            ->getRepository('WBQbankBundle:TermGroups');

        // groups at zero level
        $startLevelGroups = (!$showPublishedOnly)
            ? $conceptGroupsRepository->findByPid(0, array('weight' => 'asc', 'name' => 'asc'))
            : $conceptGroupsRepository->findBy(array('pid' => 0, 'published' => true), array('weight' => 'asc', 'name' => 'asc'));

        /* creating an array of groups and related concepts */
        $conceptsRepository = $this->getDoctrine()
            ->getRepository('WBQbankBundle:Terms');

        $paramPublished = $showPublishedOnly ? 1 : false;

        $allConcepts = $conceptsRepository->searchTerms("NOT NULL", $paramPublished, $search, $excludedIds = array());
        $allReferences = $this->getDoctrine()->getRepository('WBQbankBundle:TermGrpRef')->getConceptsReferences($showPublishedOnly, $search);

        $groupsConcepts = array();
        foreach ($allReferences as $reference){
            $groupsConcepts[$reference->getTermGroupId()->getId()][] = $reference->getTermId();
        }

        $groupsParents = array();

        $conceptsGroups = (!$showPublishedOnly)
            ? $conceptGroupsRepository->findBy(array(), array('weight' => 'asc', 'name' => 'asc'))
            : $conceptGroupsRepository->findByPublished(true, array('weight' => 'asc', 'name' => 'asc'));

        if ($countGroups = count($conceptsGroups)) {
            foreach ($conceptsGroups as $conceptsGroup) {
                $groupsParents[$conceptsGroup->getPid()][] = $conceptsGroup;
            }
        }

        // make groups tree
        $grpTree = array();
        $i = 0;
        foreach ($startLevelGroups as $group) {
            
            $sub = $this->get('helpers')->getSubitems($group->getId(), $groupsParents, $groupsConcepts);
            $items = array_key_exists($group->getId(), $groupsConcepts) ? $groupsConcepts[$group->getId()] : false;
            
           // echo '<pre>';
           // \Doctrine\Common\Util\Debug::dump($sub);
            
            if ($showEmptryGroups==0){
                //remove sub groups with no indicators
                foreach($sub as $key=>$value)
                {
                    if (!$value['items']){
                        unset($sub[$key]);
                    }
                    
                }
            }
            
            
            $grpTree['sub'][] = array(
                'id' => $group->getId(),
                'name' => $group->getName(),
                'published' => $group->getPublished(),
                'sub' => $sub,
                'items' => $items
            );
            $i++;
        }

        if($search) {
            $grpTree = $this->get('helpers')->cleanUpTree($grpTree);
            $countGroups = $this->get('helpers')->countTree($grpTree);
        }

        if (count($grpTree)) {
            $groups = $grpTree['sub'];
        }
        else {
            $groups = array();
        }
        
        //remove empty groups
        if($showEmptryGroups==0){
            foreach($groups as $key=>$value)
            {
                if (count($value['sub'])<1)
                {
                    unset($groups[$key]);
                }
            }
        }
        
        //echo '<pre>';
        //\Doctrine\Common\Util\Debug::dump($groups);exit;
        //exit;

        return $this->render('WBQbankBundle:ConceptsBack:conceptGroups.html.twig', array(
            'groups' => $groups,
            'countGroups' => $countGroups
        ));
    }

    public function conceptRepositoryAction($filterAssigned, $filterPublished, $sort, $search, Request $request)
    {

        $excludedIds = $request->request->get('excludedIds');

        $repository = $this->getDoctrine()->getRepository("WBQbankBundle:Terms");

        switch($filterPublished) {
            case "yes" : $paramPublished = 1; break;
            case "no" : $paramPublished = 0; break;
            default : $paramPublished = false; break;
        }

        switch($filterAssigned) {
            case "yes" : $paramAssigned = "NOT NULL"; break;
            case "no" : $paramAssigned = "NULL"; break;
            default : $paramAssigned = false; break;
        }

        $concepts = $repository->searchTerms($paramAssigned, $paramPublished, $search, $excludedIds, $sort);

        return $this->render('WBQbankBundle:ConceptsBack:conceptRepository.html.twig', array(
            'concepts' => $concepts,
            'countConcepts' => count($concepts),
            'active_button' => ActiveButtons::AdminConcepts
        ));

    }

    public function editConceptGroupAction($id, Request $request)
    {

        // get group by id
        $termGroup = $this->getDoctrine()->getManager()
            ->getRepository('WBQbankBundle:TermGroups')
            ->find($id);

        if (!$termGroup) {
            throw $this->createNotFoundException(
                'No group found'
            );
        }

        // form
        $form = $this->createForm(new ConceptGroupsType(), $termGroup);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return new Response('ok');
        }

        return $this->render("@WBQbank/ConceptsBack/editConceptGroup.html.twig", array(
            "form" => $form->createView(),
            "grpId" => $id
        ));
    }

    public function addConceptGroupAction(Request $request)
    {
        $termGroup = new TermGroups();

        $name = $this->get('request')->request->get('name');
        $pid = $this->get('request')->request->get('pid');

        $em = $this->getDoctrine()->getManager();
        $termGroup->setName($name);
        $termGroup->setPid($pid);
        $termGroup->setPublished(0);
        $em->persist($termGroup);
        $em->flush();

        // return new group id
        return new Response($termGroup->getId());
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
    
    
    public function editConceptAction($id, Request $request)
    {
        $request_data=$request->request->get("conceptsEdit");
        
        //update weights for related items
        if ($request_data){
        
            //weight items
            $weight_items=array(
                "termRelSources",
                "termRelResources",
                "termRelCustodians"                
            );
            
            //update weights
            foreach($weight_items as $item){
            if (isset($request_data[$item]))
                $this->updateWeight($request_data[$item]);
            }
            
            //update request array
            $request->request->set("conceptsEdit",$request_data);
        }
        
        // get concept by id
        $concept = $this->getDoctrine()->getManager()
            ->getRepository('WBQbankBundle:Terms')
            ->find($id);

        if (!$concept) {
            throw $this->createNotFoundException(
                'No concept found'
            );
        }

        // form
        $form = $this->createForm(new ConceptsEditType(), $concept);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();

            foreach ($concept->getTermRelCustodians() as $custodian) {
                if ($custodian->getOrganizationId() == null) {
                    $em->remove($custodian);
                } else {
                    $custodian->setTermId($concept);
                }
            }

            foreach ($concept->getTermRelResources() as $resource) {
                if ($resource->getResourceId() == null) {
                    $em->remove($resource);
                } else {
                    $resource->setTermId($concept);
                }
            }
            
            //sources
            foreach ($concept->getTermRelSources() as $resource) {
                if ($resource->getResourceId() == null) {
                    $em->remove($resource);
                } else {
                    $resource->setTermId($concept);
                }
            }

            $em->flush();

            return new Response('ok');
        }

        return $this->render('@WBQbank/ConceptsBack/editConcept.html.twig', array(
            'form' => $form->createView(),
            'conceptId' => $id
        ));
    }

    public function deleteConceptAction($id)
    {
        // find concept by id
        $em = $this->getDoctrine()->getManager();
        $concept = $em->getRepository('WBQbankBundle:Terms')
            ->findOneById($id);

        if (!$concept) {
            throw $this->createNotFoundException(
                'No Concept found'
            );
        }

        // delete concept
        $em->remove($concept);
        $em->flush();
        return new Response('ok');
    }

    /**
     * Delete group
     * and detach related concepts
     * onDelete: CASCADE
     */
    public function deleteConceptGroupAction($id)
    {
        // find group by id
        $em = $this->getDoctrine()->getManager();
        $termGroup = $em->getRepository('WBQbankBundle:TermGroups')
            ->findOneById($id);

        if (!$termGroup) {
            throw $this->createNotFoundException(
                'No Group found'
            );
        }

        //find subgroups
        $subGroups = $em->getRepository('WBQbankBundle:TermGroups')
            ->findByPid($id);

        // delete group if does not contain subgroups
        if (count($subGroups) == 0) {
            $em->remove($termGroup);
            $em->flush();
            return new Response('ok');
        } else {
            return new Response('Has subgroups');
        }
    }

    /**
     * Attach concept to group after dragging
     */
    public function attachConceptToGroupAction($grpId, $nodeId)
    {
        if ($grpId > 0) {

            // group object
            $group = $this->getDoctrine()
                ->getRepository('WBQbankBundle:TermGroups')
                ->find($grpId);

            // concept object
            $concept = $this->getDoctrine()
                ->getRepository('WBQbankBundle:Terms')
                ->find($nodeId);

            // group/concept reference
            $termGrpRef = new TermGrpRef();
            $termGrpRef->setTermGroupId($group);
            $termGrpRef->setTermId($concept);
            $termGrpRef->setWeight(0);

            // avoid duplicate entry
            $validator = $this->get('validator');
            $errors = $validator->validate($termGrpRef);

            if (count($errors) > 0) {
                // reference already exists
                $errorsString = (string)$errors;
                return new Response($errorsString);
            } else {
                // write reference into db
                $em = $this->getDoctrine()->getManager();
                $em->persist($termGrpRef);
                $em->flush();
                return new Response('ok');
            }
        } else {
            return new Response('0');
        }
    }

    public function deleteConceptFromGroupsAction($grpId, $nodeId)
    {
        // find Concept Group by id
        $em = $this->getDoctrine()->getManager();
        $termGrpRef = $em->getRepository('WBQbankBundle:TermGrpRef')
            ->findOneBy(
                array('termGroupId' => $grpId, 'termId' => $nodeId)
            );

        if (!$termGrpRef) {
            return new Response('Not found');
        } else {
            // delete Concept Group from db
            $em->remove($termGrpRef);
            $em->flush();

            return new Response('ok');
        }
    }

    public function moveConceptToGroupAction($grpId, $grpOldId, $nodeId)
    {
        // group object
        $group = $this->getDoctrine()
            ->getRepository('WBQbankBundle:TermGroups')
            ->find($grpId);

        // concept object
        $concept = $this->getDoctrine()
            ->getRepository('WBQbankBundle:Terms')
            ->find($nodeId);

        // group/concept reference
        $termGrpRef = $this->getDoctrine()
            ->getRepository('WBQbankBundle:TermGrpRef')
            ->findOneBy(
                array('termGroupId' => $grpOldId, 'termId' => $nodeId)
            );

        $termGrpRef->setTermGroupId($group);

        // avoid duplicate entry
        $validator = $this->get('validator');
        $errors = $validator->validate($termGrpRef);

        if (count($errors) > 0) {
            // reference already exists
            $errorsString = (string)$errors;
            return new Response($errorsString);
        }
        else if (is_numeric($grpId) &&  is_numeric($grpOldId) && is_numeric($nodeId)) {
            // write reference into db
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return new Response('ok');
        }
        else {
            return new Response('Missing argument');
        }
    }

    /**
     * Update parent id for a group
     */
    public function updateGroupPidAction($id, $pid)
    {
        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('WBQbankBundle:TermGroups')
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
     * Update weight of all group concept relations
     */
    public function updateGrpRefWeightAction($groupId, Request $request)
    {
        $weights = $request->request->get('weights');
        $em = $this->getDoctrine()->getManager();
        $grpRefs = $em->getRepository('WBQbankBundle:TermGrpRef')->findByTermGroupId($groupId);
        foreach ($grpRefs as $grpRef) {
            $grpRef->setWeight($weights[$grpRef->getTermId()->getId()]);
        }

        $em->flush();
        return new Response('ok');
    }

    /**
     * Update weight of all concept groups inside of specific group
     */
    public function updateGrpWeightAction($pid, Request $request)
    {
        $weights = $request->request->get('weights');
        $em = $this->getDoctrine()->getManager();
        $grpRefs = $em->getRepository('WBQbankBundle:TermGroups')->findByPid($pid);
        foreach ($grpRefs as $grpRef) {
            $grpRef->setWeight($weights[$grpRef->getId()]);
        }

        $em->flush();
        return new Response('ok');
    }


    /**
     * Concept breadcrumbs
     * If concept belongs to more than one - show all breadcrumbs
     */
    public function conceptBreadcrumbsAction($concId, $public)
    {
        // first parent groups
        $em = $this->getDoctrine()->getManager();
        $relGroups = $em->getRepository('WBQbankBundle:TermGrpRef')
            ->findByTermId($concId);

        // make array of parent groups for each first parent group
        $parentGroups = array();

        foreach ($relGroups as $relGroup) {

            $this->get('helpers')->resetParentGroups();

            $group = $em->getRepository('WBQbankBundle:TermGroups')
                ->find($relGroup->getTermGroupId());

            $parentGroups[] = array(
                'id' => $group->getId(),
                'name' => $group->getName(),
                'parents' => $this->get('helpers')->getParentGroups($group->getPid(), 'WBQbankBundle:TermGroups'),
            );
        }

        // concept
        $concept = $em->getRepository('WBQbankBundle:Terms')
            ->find($concId);

        return $this->render('WBQbankBundle:ConceptsBack:conceptBreadcrumbs.html.twig', array(
            'parentGroups' => $parentGroups,
            'concName' => $concept->getName(),
            'concId' => $concept->getId(),
            'public' => $public
        ));
    }

    /**
     * Group breadcrumb
     * array of parent groups
     */
    public function conceptGroupBreadcrumbAction($grpId, $public)
    {
        $this->get('helpers')->resetParentGroups();

        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('WBQbankBundle:TermGroups')
            ->find($grpId);

        $parents = $this->get('helpers')->getParentGroups($group->getPid(), 'WBQbankBundle:TermGroups');

        return $this->render('WBQbankBundle:ConceptsBack:conceptGroupBreadcrumb.html.twig', array(
            'group' => $group,
            'parentGroups' => $parents,
            'public' => $public
        ));
    }

    /**
     * Groups by parent id
     */
    public function conceptGroupsListAction($pid)
    {
        $conceptGroupsRepo = $this->getDoctrine()
            ->getRepository('WBQbankBundle:TermGroups');

        $conceptGroups = $conceptGroupsRepo->findByPid($pid);

        return $this->render('WBQbankBundle:ConceptsBack:conceptGroupsList.html.twig', array(
            'conceptGroups' => $conceptGroups,
            'pid' => $pid
        ));
    }
    public function publishUnpublishAction($id,$publish){

        $em =  $this->getDoctrine()->getManager();
        $publish = (boolean) $publish;
        $entity = $em->getRepository('WBQbankBundle:Terms')->findOneBy(["id"=>$id]);

        $entity->setPublished($publish);
        $em->flush();

        return new Response("ok");

    }
    public function publishUnpublishGroupAction($id,$publish){

        $em =  $this->getDoctrine()->getManager();
        $publish = (boolean) $publish;
        $entity = $em->getRepository('WBQbankBundle:TermGroups')->findOneBy(["id"=>$id]);

        $entity->setPublished($publish);
        $em->flush();

        return new Response("ok");
    }
}
