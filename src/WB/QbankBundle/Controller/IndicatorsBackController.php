<?php

namespace WB\QbankBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use WB\QbankBundle\Entity\User;
use WB\QbankBundle\Entity\Indicators;
use WB\QbankBundle\Entity\IndicatorGroups;
use WB\QbankBundle\Entity\IndicatorAliases;
use WB\QbankBundle\Entity\IndicatorCollections;
use WB\QbankBundle\Entity\IndGrpRef;
use WB\QbankBundle\Enums\IndicatorTreeTypes;
use WB\QbankBundle\Form\Type\IndicatorGroupsType;
use WB\QbankBundle\Form\Type\IndicatorsType;
use WB\QbankBundle\Form\Type\IndicatorsEditType;
use WB\QbankBundle\Form\Type\IndicatorCollectionsType;
use WB\QbankBundle\Entity\IndCollectionRef;
use WB\QbankBundle\Enums\ActiveButtons;


class IndicatorsBackController extends Controller
{
    public function indicatorsAction()
    {
        return $this->render(
            '@WBQbank/IndicatorsBack/indicators.html.twig',
            array(
                'active_button' => ActiveButtons::AdminIndicators
            )
        );
    }

    public function indicatorGroupsAction($publishedOnly, $search,Request $request)
    {
        //show empty groups or not?
        $showEmptryGroups=intval($request->query->get('show_empty_groups'));//expects 1 or 0
        
        $showPublishedOnly = ($publishedOnly == 'true') ? true : false;

        $indGroupsRepo = $this->getDoctrine()
            ->getRepository('WBQbankBundle:IndicatorGroups');

        // groups at zero level
        $startLevelGroups = (!$showPublishedOnly)
            ? $indGroupsRepo->findByPid(0, array('weight' => 'asc', 'name' => 'asc'))
            : $indGroupsRepo->findBy(array('pid' => 0, 'published' => true), array('weight' => 'asc', 'name' => 'asc'));

        /* creating an array of groups and related indicators */
        $indRepository = $this->getDoctrine()
            ->getRepository('WBQbankBundle:Indicators');

        $paramPublished = $showPublishedOnly ? 1 : false;

        $allIndicators = $indRepository->searchIndicators("NOT NULL", $paramPublished, 'ASC', $search, IndicatorTreeTypes::Groups);
        $allReferences = $this->getDoctrine()->getRepository('WBQbankBundle:IndGrpRef')->getIndicatorsReferences($showPublishedOnly, $search);

        $groupsIndicators = array();
        foreach ($allReferences as $reference) {
            $groupsIndicators[$reference->getIndGroupId()->getId()][] = $reference->getIndId();
        }

        $groupsParents = array();

        $indGroups = (!$showPublishedOnly)
            ? $indGroupsRepo->findBy(array(), array('weight' => 'asc', 'name' => 'asc'))
            : $indGroupsRepo->findByPublished(true, array('weight' => 'asc', 'name' => 'asc'));

        if ($countGroups = count($indGroups)) {
            foreach ($indGroups as $indGroup) {
                $groupsParents[$indGroup->getPid()][] = $indGroup;
            }
        }

        
        //echo '<pre>';
        //\Doctrine\Common\Util\Debug::dump($startLevelGroups);exit;

        
        // make groups tree
        $grpTree = array();
        foreach ($startLevelGroups as $group) {
            
            //get indicators for the group
            $indicator_items=array_key_exists($group->getId(), $groupsIndicators) ? $groupsIndicators[$group->getId()] : false;
            
            $sub_items=$this->get('helpers')->getSubitems($group->getId(), $groupsParents, $groupsIndicators);
            
            if ($showEmptryGroups==0)
            {
                //remove sub groups with no indicators
                foreach($sub_items as $key=>$value)
                {
                    if (!$value['items']){
                        unset($sub_items[$key]);
                    }
                    
                }
            }
            

            $grpTree['sub']['group-'.$group->getId()] = array(
                'id' => $group->getId(),
                'name' => $group->getName(),
                'published' => $group->getPublished(),
                'sub' => $sub_items,
                'items' => $indicator_items
            );
        }
        

        if ($search) {
            $grpTree = $this->get('helpers')->cleanUpTree($grpTree);
            $countGroups = $this->get('helpers')->countTree($grpTree);
        }

        if (count($grpTree)) {
            $groups = $grpTree['sub'];
        } else {
            $groups = array();
        }

        
        //echo '<pre>';
        //\Doctrine\Common\Util\Debug::dump($startLevelGroups);exit;
        
        //remove empty groups
        if ($showEmptryGroups==0) {
            foreach ($groups as $key => $value) {
                if (count($value['sub']) < 1) {
                    unset($groups[$key]);
                }
            }
        }

        return $this->render('WBQbankBundle:IndicatorsBack:indicatorGroups.html.twig', array(
            'groups' => $groups,
            'countGroups' => $countGroups
        ));
    }

    public function indicatorCollectionsAction($publishedOnly, $search, Request $request)
    {
        //show empty groups or not?
        $showEmptryGroups=intval($request->query->get('show_empty_groups'));//expects 1 or 0
        
        $showPublishedOnly = ($publishedOnly == 'true') ? true : false;

        $indCollRepo = $this->getDoctrine()
            ->getRepository('WBQbankBundle:IndicatorCollections');

        // groups at zero level
        $startLevelCollections = (!$showPublishedOnly)
            ? $indCollRepo->findByPid(0, array('weight' => 'asc', 'name' => 'asc'))
            : $indCollRepo->findBy(array('pid' => 0, 'published' => true), array('weight' => 'asc', 'name' => 'asc'));

        /* creating an array of collections and related indicators */
        $indRepository = $this->getDoctrine()
            ->getRepository('WBQbankBundle:Indicators');

        $paramPublished = $showPublishedOnly ? 1 : false;

        $allIndicators = $indRepository->searchIndicators("NOT NULL", $paramPublished, 'ASC', $search, IndicatorTreeTypes::Collections);
        $allReferences = $this->getDoctrine()->getRepository('WBQbankBundle:IndCollectionRef')->getIndicatorsReferences($publishedOnly, $search);

        $collectionsIndicators = array();
        foreach ($allReferences as $reference) {
            $collectionsIndicators[$reference->getIndCollId()->getId()][] = $reference->getIndId();
        }

        $collectionsParents = array();

        $indCollections = (!$showPublishedOnly)
            ? $indCollRepo->findBy(array(), array('weight' => 'asc', 'name' => 'asc'))
            : $indCollRepo->findByPublished(true, array('weight' => 'asc', 'name' => 'asc'));

        if ($countCollections = count($indCollections)) {
            foreach ($indCollections as $indCollection) {
                $collectionsParents[$indCollection->getPid()][] = $indCollection;
            }
        }

        // make collections tree
        $collTree = array();
        $i = 0;
        foreach ($startLevelCollections as $collection) {

            $sub_items=$this->get('helpers')->getSubitems($collection->getId(), $collectionsParents, $collectionsIndicators);
            $coll_items=array_key_exists($collection->getId(), $collectionsIndicators) ? $collectionsIndicators[$collection->getId()] : false;

            /*if($showEmptryGroups==0)
            {

                //remove sub groups with no sub items
                foreach($sub_items as $key=>$value)
                {
                    if (!$value['items']){
                        unset($sub_items[$key]);
                    }
                }
            }*/

            $collTree['sub'][] = array(
                'id' => $collection->getId(),
                'name' => $collection->getName(),
                'published' => $collection->getPublished(),
                'sub' => $sub_items,
                'items' => $coll_items
            );
            $i++;
        }


        if ($search) {
            $collTree = $this->get('helpers')->cleanUpTree($collTree);
            $countCollections = $this->get('helpers')->countTree($collTree);
        }

        $collections = $collTree['sub'];

/*
        if($showEmptryGroups==0){
            //remove empty groups
            foreach($collections as $key=>$value)
            {
                if (count($value['sub'])<1 && !$value['items'])
                {
                    unset($collections[$key]);
                }
            }
        }*/

        return $this->render('WBQbankBundle:IndicatorsBack:indicatorCollections.html.twig', array(
            'collections' => $collections,
            'countCollections' => $countCollections
        ));
    }

    public function indicatorRepositoryAction($filterAssigned, $filterPublished, $sort, $search)
    {
        $repository = $this->getDoctrine()
            ->getRepository('WBQbankBundle:Indicators');

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

        $indicators = $repository->searchIndicators($paramAssigned, $paramPublished, $sort, $search, IndicatorTreeTypes::Groups);


        return $this->render('WBQbankBundle:IndicatorsBack:indicatorRepository.html.twig', array(
            'indicators' => $indicators,
            'countIndicators' => count($indicators),
            'active_button' => ActiveButtons::AdminIndicators
        ));
    }

    public function collectionIndicatorRepositoryAction($filterAssigned, $filterPublished, $sort, $search)
    {
        $repository = $this->getDoctrine()
            ->getRepository('WBQbankBundle:Indicators');

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

        $indicators = $repository->searchIndicators($paramAssigned, $paramPublished, $sort, $search, IndicatorTreeTypes::Collections);
        return $this->render('WBQbankBundle:IndicatorsBack:indicatorCollectionRepository.html.twig', array(
            'indicators' => $indicators,
            'countIndicators' => count($indicators),
        ));
    }

    public function addIndicatorGroupAction(Request $request)
    {
        $indGroup = new IndicatorGroups();

        $name = $this->get('request')->request->get('name');
        $pid = $this->get('request')->request->get('pid');

        $em = $this->getDoctrine()->getManager();
        $indGroup->setName($name);
        $indGroup->setPid($pid);
        $indGroup->setPublished(0);
        $em->persist($indGroup);
        $em->flush();

        // return new group id
        return new Response($indGroup->getId());
    }

    public function addIndicatorCollectionAction(Request $request)
    {
        $indCollection = new IndicatorCollections();

        $name = $this->get('request')->request->get('name');
        $pid = $this->get('request')->request->get('pid');

        $em = $this->getDoctrine()->getManager();
        $indCollection->setName($name);
        $indCollection->setPid($pid);
        $indCollection->setPublished(0);
        $em->persist($indCollection);
        $em->flush();

        // return new group id
        return new Response($indCollection->getId());
    }

    public function editIndicatorGroupAction($id, Request $request)
    {
        // get group by id
        $indGroup = $this->getDoctrine()->getManager()
            ->getRepository('WBQbankBundle:IndicatorGroups')
            ->find($id);

        if (!$indGroup) {
            throw $this->createNotFoundException(
                'No group found'
            );
        }

        // form
        $form = $this->createForm(new IndicatorGroupsType(), $indGroup);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return new Response('ok');
        }

        return $this->render('WBQbankBundle:IndicatorsBack:editIndicatorGroup.html.twig', array(
            'form' => $form->createView(),
            'grpId' => $id
        ));
    }

    public function editIndicatorCollectionAction($id, Request $request)
    {
        // get collection by id
        $indCollection = $this->getDoctrine()->getManager()
            ->getRepository('WBQbankBundle:IndicatorCollections')
            ->find($id);

        if (!$indCollection) {
            throw $this->createNotFoundException(
                'No collection found'
            );
        }

        // form
        $form = $this->createForm(new IndicatorCollectionsType(), $indCollection);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return new Response('ok');
        }

        return $this->render('WBQbankBundle:IndicatorsBack:editIndicatorCollection.html.twig', array(
            'form' => $form->createView(),
            'collId' => $id
        ));
    }

    /**
     * Delete group
     * and detach related indicators
     * onDelete: CASCADE
     */
    public function deleteIndicatorGroupAction($id)
    {
        // find group by id
        $em = $this->getDoctrine()->getManager();
        $indGroup = $em->getRepository('WBQbankBundle:IndicatorGroups')
            ->findOneById($id);

        if (!$indGroup) {
            throw $this->createNotFoundException(
                'No Group found'
            );
        }

        //find subgroups
        $subGroups = $em->getRepository('WBQbankBundle:IndicatorGroups')
            ->findByPid($id);

        // delete group if does not contain subgroups
        if (count($subGroups) == 0) {
            $em->remove($indGroup);
            $em->flush();
            return new Response('ok');
        } else {
            return new Response('Has subgroups');
        }
    }

    /**
     * Delete collection
     * and detach related indicators
     * onDelete: CASCADE
     */
    public function deleteIndicatorCollectionAction($id)
    {
        // find collection by id
        $em = $this->getDoctrine()->getManager();
        $indCollection = $em->getRepository('WBQbankBundle:IndicatorCollections')
            ->findOneById($id);

        if (!$indCollection) {
            throw $this->createNotFoundException(
                'No Collection found'
            );
        }

        //find subcollections
        $subCollections = $em->getRepository('WBQbankBundle:IndicatorCollections')
            ->findByPid($id);

        // delete collection if does not contain subcollections
        if (count($subCollections) == 0) {
            $em->remove($indCollection);
            $em->flush();
            return new Response('ok');
        } else {
            return new Response('Has subcollections');
        }
    }

    /**
     * Attach indicator to group after dragging
     */
    public function attachIndicatorToGroupAction($grpId, $nodeId)
    {
        if ($grpId > 0) {

            // group object
            $group = $this->getDoctrine()
                ->getRepository('WBQbankBundle:IndicatorGroups')
                ->find($grpId);

            // indicator object
            $indicator = $this->getDoctrine()
                ->getRepository('WBQbankBundle:Indicators')
                ->find($nodeId);

            // group/indicator reference
            $indGrpRef = new IndGrpRef();
            $indGrpRef->setIndGroupId($group);
            $indGrpRef->setIndId($indicator);
            $indGrpRef->setWeight(0);

            // avoid duplicate entry
            $validator = $this->get('validator');
            $errors = $validator->validate($indGrpRef);

            if (count($errors) > 0) {
                // reference already exists
                $errorsString = (string)$errors;
                return new Response($errorsString);
            } else {
                // write reference into db
                $em = $this->getDoctrine()->getManager();
                $em->persist($indGrpRef);
                $em->flush();
                return new Response('ok');
            }
        } else {
            return new Response('0');
        }

    }

    /**
     * Attach indicator to collection after dragging
     */
    public function attachIndicatorToCollectionAction($collId, $nodeId)
    {
        if ($collId > 0) {

            // collection object
            $collection = $this->getDoctrine()
                ->getRepository('WBQbankBundle:IndicatorCollections')
                ->find($collId);

            // indicator object
            $indicator = $this->getDoctrine()
                ->getRepository('WBQbankBundle:Indicators')
                ->find($nodeId);

            // collection/indicator reference
            $indCollRef = new IndCollectionRef();
            $indCollRef->setIndCollId($collection);
            $indCollRef->setIndId($indicator);
            $indCollRef->setWeight(0);

            // avoid duplicate entry
            $validator = $this->get('validator');
            $errors = $validator->validate($indCollRef);

            if (count($errors) > 0) {
                // reference already exists
                $errorsString = (string)$errors;
                return new Response($errorsString);
            } else {
                // write reference into db
                $em = $this->getDoctrine()->getManager();
                $em->persist($indCollRef);
                $em->flush();
                return new Response('ok');
            }
        } else {
            return new Response('0');
        }

    }

    public function deleteIndicatorFromGroupsAction($grpId, $nodeId)
    {
        // find Indicator Group by id
        $em = $this->getDoctrine()->getManager();
        $indGrpRef = $em->getRepository('WBQbankBundle:IndGrpRef')
            ->findOneBy(
                array('indGroupId' => $grpId, 'indId' => $nodeId)
            );

        if (!$indGrpRef) {
            return new Response('Not found');
        } else {
            // delete Indicator Group from db
            $em->remove($indGrpRef);
            $em->flush();

            return new Response('ok');
        }
    }

    public function deleteIndicatorFromCollectionsAction($collId, $nodeId)
    {
        // find Indicator Collection by id
        $em = $this->getDoctrine()->getManager();
        $indCollRef = $em->getRepository('WBQbankBundle:IndCollectionRef')
            ->findOneBy(
                array('indCollId' => $collId, 'indId' => $nodeId)
            );

        if (!$indCollRef) {
            return new Response('Not found');
        } else {
            // delete Indicator Collection from db
            $em->remove($indCollRef);
            $em->flush();

            return new Response('ok');
        }
    }

    public function moveIndicatorToGroupAction($grpId, $grpOldId, $nodeId)
    {
        // group object
        $group = $this->getDoctrine()
            ->getRepository('WBQbankBundle:IndicatorGroups')
            ->find($grpId);

        // indicator object
        $indicator = $this->getDoctrine()
            ->getRepository('WBQbankBundle:Indicators')
            ->find($nodeId);

        // group/indicator reference
        $indGrpRef = $this->getDoctrine()
            ->getRepository('WBQbankBundle:IndGrpRef')
            ->findOneBy(
                array('indGroupId' => $grpOldId, 'indId' => $nodeId)
            );

        $indGrpRef->setIndGroupId($group);

        // avoid duplicate entry
        $validator = $this->get('validator');
        $errors = $validator->validate($indGrpRef);

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

    public function moveIndicatorToCollectionAction($collId, $collOldId, $nodeId)
    {
        // collection object
        $collection = $this->getDoctrine()
            ->getRepository('WBQbankBundle:IndicatorCollections')
            ->find($collId);

        // indicator object
        $indicator = $this->getDoctrine()
            ->getRepository('WBQbankBundle:Indicators')
            ->find($nodeId);

        // collection/indicator reference
        $indCollRef = $this->getDoctrine()
            ->getRepository('WBQbankBundle:IndCollectionRef')
            ->findOneBy(
                array('indCollId' => $collOldId, 'indId' => $nodeId)
            );

        $indCollRef->setIndCollId($collection);

        // avoid duplicate entry
        $validator = $this->get('validator');
        $errors = $validator->validate($indCollRef);

        if (count($errors) > 0) {
            // reference already exists
            $errorsString = (string)$errors;
            return new Response($errorsString);
        } else {
            // write reference into db
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return new Response('ok');
        }
    }

    /**
     * Add indicator to groups and repository
     * or to repository
     */
    public function addIndicatorAction(Request $request)
    {
        $indicator = new Indicators();

        $name = $this->get('request')->request->get('name');
        $grpId = $this->get('request')->request->get('grpId');

        $em = $this->getDoctrine()->getManager();

        // set reference to group
        if ($grpId != 0) {

            // indicator group object
            $indGrp = $em->getRepository('WBQbankBundle:IndicatorGroups')
                ->find($grpId);

            if ($indGrp) {
                $indGrpRef = new IndGrpRef();
                $indGrpRef->setIndGroupId($indGrp);
                $indGrpRef->setIndId($indicator);
                $indGrpRef->setWeight(0);
                $em->persist($indGrpRef);
            }
        }

        $date = new \DateTime("now");
        $indicator->setName($name);
        $indicator->setWeight(0);
        $indicator->setModified($date);
        $indicator->setCreated($date);
        $indicator->setPublished(0);

        $em->persist($indicator);
        $em->flush();

        // return new indicator id
        return new Response($indicator->getId());
    }

    /**
     * Add indicator to collections and repository
     * or to repository
     */
    public function addCollectionsIndicatorAction(Request $request)
    {
        $indicator = new Indicators();

        $name = $this->get('request')->request->get('name');
        $collId = $this->get('request')->request->get('collId');

        $em = $this->getDoctrine()->getManager();

        // set reference to collection
        if ($collId != 0) {

            // indicator collection object
            $indColl = $em->getRepository('WBQbankBundle:IndicatorCollections')
                ->find($collId);

            if ($indColl) {
                $indCollRef = new IndCollectionRef();
                $indCollRef->setIndCollId($indColl);
                $indCollRef->setIndId($indicator);
                $indCollRef->setWeight(0);
                $em->persist($indCollRef);
            }
        }

        $date = new \DateTime("now");
        $indicator->setName($name);
        $indicator->setWeight(0);
        $indicator->setModified($date);
        $indicator->setCreated($date);
        $indicator->setPublished(0);

        $em->persist($indicator);
        $em->flush();

        // return new indicator id
        return new Response($indicator->getId());
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
    

    public function editIndicatorAction($id, Request $request)
    {
        $request_data=$request->request->get("indicatorsEdit");
        
        //update weights for related items
        if ($request_data){
        
            //weight items
            $weight_items=array(
                "indicatorRelClassifications",
                "indicatorRelResources",
                "indicatorRelSources",
                "indicatorRelTerms",
                "indicatorRelModules"
            );
            
            //update weights
            foreach($weight_items as $item){
            if (isset($request_data[$item]))
                $this->updateWeight($request_data[$item]);
            }
            
            //update request array
            $request->request->set("indicatorsEdit",$request_data);
        }
        
        
        // get indicator by id
        $indicator = $this->getDoctrine()->getManager()
            ->getRepository('WBQbankBundle:Indicators')
            ->find($id);

        if (!$indicator) {
            throw $this->createNotFoundException(
                'No indicator found'
            );
        }
        
        // form
        $form = $this->createForm(new IndicatorsEditType(), $indicator);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
        
            $em = $this->getDoctrine()->getManager();
            
            // set indicator id for each alias
            // otherwise alias is saved but null is set for indId
            foreach ($indicator->getIndicatorAlias() as $alias) {
                if ($alias->getName() != '') {
                    $alias->setIndId($indicator);
                } else {
                    // remove deleted alias from db
                    $em->remove($alias);
                }
            }
            
            foreach ($indicator->getIndicatorRelCustodians() as $custodian) {
                if ($custodian->getOrganizationId() == null) {
                    $em->remove($custodian);
                } else {
                    $custodian->setIndId($indicator);
                }
            }        
            
            foreach ($indicator->getIndicatorRelResources() as $resource) {
                if ($resource->getResourceId() == null) {
                    $em->remove($resource);
                } else {
                    $resource->setIndId($indicator);
                }
            }
            
            foreach ($indicator->getIndicatorRelSources() as $source) {
                if ($source->getResourceId() == null) {
                    $em->remove($source);
                } else {
                    $source->setIndId($indicator);
                }
            }
            
            
            foreach ($indicator->getIndicatorRelClassifications() as $classification) {
                if ($classification->getClassificationId() == null) {
                    $em->remove($classification);
                } else {
                    $classification->setIndId($indicator);
                }
            }
            
            foreach ($indicator->getIndicatorRelTerms() as $concept) {
                if ($concept->getTermId() == null) {
                    $em->remove($concept);
                } else {
                    $concept->setIndId($indicator);
                }
            }
            
            foreach ($indicator->getIndicatorRelModules() as $questionnaire) {
                if ($questionnaire->getModuleId() == null) {
                    $em->remove($questionnaire);
                } else {
                    $questionnaire->setIndId($indicator);
                }
            }
            
            $em->flush();
        
            return new Response('ok');
        }

        return $this->render('WBQbankBundle:IndicatorsBack:editIndicator.html.twig', array(
            'form' => $form->createView(),
            'indId' => $id
        ));
    }

    /**
     * Delete indicator from repository
     * and detach indicator from groups
     * onDelete: CASCADE
     */
    public function deleteIndicatorAction($id)
    {
        // find indicator by id
        $em = $this->getDoctrine()->getManager();
        $indicator = $em->getRepository('WBQbankBundle:Indicators')
            ->findOneById($id);

        if (!$indicator) {
            throw $this->createNotFoundException(
                'No Indicator found'
            );
        }

        // delete indicator
        $em->remove($indicator);
        $em->flush();
        return new Response('ok');
    }

    /**
     * Update parent id for a group
     */
    public function updateGroupPidAction($id, $pid)
    {
        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('WBQbankBundle:IndicatorGroups')
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
     * Update parent id for a collection
     */
    public function updateCollectionPidAction($id, $pid)
    {
        $em = $this->getDoctrine()->getManager();
        $collection = $em->getRepository('WBQbankBundle:IndicatorCollections')
            ->findOneById($id);

        if (!$collection) {
            throw $this->createNotFoundException(
                'No collection found'
            );
        }

        $collection->setPid($pid);
        $em->flush();

        return new Response('ok');
    }


    /**
     * Update weight of all group indicators relations
     */
    public function updateGrpRefWeightAction($groupId, Request $request)
    {
        $weights = $request->request->get('weights');
        $em = $this->getDoctrine()->getManager();
        $grpRefs = $em->getRepository('WBQbankBundle:IndGrpRef')->findByIndGroupId($groupId);
        foreach ($grpRefs as $grpRef) {
            $grpRef->setWeight($weights[$grpRef->getIndId()->getId()]);
        }

        $em->flush();
        return new Response('ok');
    }


    /**
     * Update weight of all indicator groups inside of specific group
     */
    public function updateGrpWeightAction($pid, Request $request)
    {       
        $weights = $request->request->get('weights');
        $em = $this->getDoctrine()->getManager();
        $grpRefs = $em->getRepository('WBQbankBundle:IndicatorGroups')->findByPid($pid);
        foreach ($grpRefs as $grpRef) {
            $grpRef->setWeight($weights[$grpRef->getId()]);
        }

        $em->flush();
        return new Response('ok');
    }


    /**
     * Update weight of all indicator collection inside of specific collection
     */
    public function updateCollWeightAction($pid, Request $request)
    {
        $weights = $request->request->get('weights');
        $em = $this->getDoctrine()->getManager();
        $grpRefs = $em->getRepository('WBQbankBundle:IndicatorCollections')->findByPid($pid);
        foreach ($grpRefs as $grpRef) {
            $grpRef->setWeight($weights[$grpRef->getId()]);
        }

        $em->flush();
        return new Response('ok');
    }


    /**
     * Update weight of all collection indicators relations
     */
    public function updateCollRefWeightAction($groupId, Request $request)
    {
        $weights = $request->request->get('weights');
        $em = $this->getDoctrine()->getManager();
        $collRefs = $em->getRepository('WBQbankBundle:IndCollectionRef')->findByIndCollId($groupId);
        foreach ($collRefs as $collRef) {
            $collRef->setWeight($weights[$collRef->getIndId()->getId()]);

        }

        $em->flush();
        return new Response('ok');
    }

    /**
     * Indicator breadcrumbs
     * If indicator belongs to more than one - show all breadcrumbs
     */
    public function indicatorBreadcrumbsAction($indId, $public)
    {
        // first parent groups
        $em = $this->getDoctrine()->getManager();
        $relGroups = $em->getRepository('WBQbankBundle:IndGrpRef')
            ->findByIndId($indId);

        // make array of parent groups for each first parent group
        $parentGroups = array();

        foreach ($relGroups as $relGroup) {

            $this->get('helpers')->resetParentGroups();

            $group = $em->getRepository('WBQbankBundle:IndicatorGroups')
                ->find($relGroup->getIndGroupId());

            $parentGroups[] = array(
                'id' => $group->getId(),
                'name' => $group->getName(),
                'parents' => $this->get('helpers')->getParentGroups($group->getPid(), 'WBQbankBundle:IndicatorGroups'),
            );
        }

        // indicator
        $indicator = $em->getRepository('WBQbankBundle:Indicators')
            ->find($indId);

        return $this->render('WBQbankBundle:IndicatorsBack:indicatorBreadcrumbs.html.twig', array(
            'parentGroups' => $parentGroups,
            'indName' => $indicator->getName(),
            'indId' => $indicator->getId(),
            'public' => $public
        ));
    }

    /**
     * Collection Indicator breadcrumbs
     * If indicator belongs to more than one - show all breadcrumbs
     */
    public function collectionIndicatorBreadcrumbsAction($indId, $public)
    {
        // first parent collections
        $em = $this->getDoctrine()->getManager();
        $relCollections = $em->getRepository('WBQbankBundle:IndCollectionRef')
            ->findByIndId($indId);

        // make array of parent collections for each first parent collection
        $parentCollections = array();

        foreach ($relCollections as $relCollection) {

            $this->get('helpers')->resetParentCollections();

            $collection = $em->getRepository('WBQbankBundle:IndicatorCollections')
                ->find($relCollection->getIndCollId());

            $parentCollections[] = array(
                'id' => $collection->getId(),
                'name' => $collection->getName(),
                'parents' => $this->get('helpers')->getParentCollections($collection->getPid()),
            );
        }

        // indicator
        $indicator = $em->getRepository('WBQbankBundle:Indicators')
            ->find($indId);

        return $this->render('WBQbankBundle:IndicatorsBack:collectionIndicatorBreadcrumbs.html.twig', array(
            'parentCollections' => $parentCollections,
            'indName' => $indicator->getName(),
            'indId' => $indicator->getId(),
            'public' => $public
        ));
    }

    /**
     * Group breadcrumb
     * array of parent groups
     */
    public function indicatorGroupBreadcrumbAction($grpId, $public)
    {
        $this->get('helpers')->resetParentGroups();

        $em = $this->getDoctrine()->getManager();
        $group = $em->getRepository('WBQbankBundle:IndicatorGroups')
            ->find($grpId);

        $parents = $this->get('helpers')->getParentGroups($group->getPid(), 'WBQbankBundle:IndicatorGroups');

        return $this->render('WBQbankBundle:IndicatorsBack:indicatorGroupBreadcrumb.html.twig', array(
            'group' => $group,
            'parentGroups' => $parents,
            'public' => $public
        ));
    }

    /**
     * Collection breadcrumb
     * array of parent collections
     */
    public function collectionBreadcrumbAction($collId, $public)
    {
        $this->get('helpers')->resetParentCollections();

        $em = $this->getDoctrine()->getManager();
        $collection = $em->getRepository('WBQbankBundle:IndicatorCollections')
            ->find($collId);

        $parents = $this->get('helpers')->getParentCollections($collection->getPid());

        return $this->render('WBQbankBundle:IndicatorsBack:collectionBreadcrumb.html.twig', array(
            'collection' => $collection,
            'parentCollections' => $parents,
            'public' => $public
        ));
    }

    public function publishUnpublishAction($id,$publish){

        $em =  $this->getDoctrine()->getManager();
        $publish = (boolean) $publish;
        $entity = $em->getRepository('WBQbankBundle:Indicators')->findOneBy(["id"=>$id]);

        $entity->setPublished($publish);
        $em->flush();

        return new Response("ok");

    }
    public function publishUnpublishGroupAction($id,$publish){

        $em =  $this->getDoctrine()->getManager();
        $publish = (boolean) $publish;
        $entity = $em->getRepository('WBQbankBundle:IndicatorGroups')->findOneBy(["id"=>$id]);

        $entity->setPublished($publish);
        $em->flush();

        return new Response("ok");
    }

    public function publishUnpublishCollectionAction($id,$publish){

        $em =  $this->getDoctrine()->getManager();
        $publish = (boolean) $publish;
        $entity = $em->getRepository('WBQbankBundle:IndicatorCollections')->findOneBy(["id"=>$id]);

        $entity->setPublished($publish);
        $em->flush();

        return new Response("ok");
    }


    /**
     * Groups by parent id
     */
    public function indicatorGroupsListAction($pid)
    {
        $indGroupsRepo = $this->getDoctrine()
            ->getRepository('WBQbankBundle:IndicatorGroups');

        $indGroups = $indGroupsRepo->findByPid($pid);

        return $this->render('WBQbankBundle:IndicatorsBack:indicatorGroupsList.html.twig', array(
            'indGroups' => $indGroups,
            'pid' => $pid
        ));
    }

    /**
     * Groups by parent id
     */
    public function indicatorCollectionsListAction($pid)
    {
        $indCollRepo = $this->getDoctrine()
            ->getRepository('WBQbankBundle:IndicatorCollections');

        $indCollections = $indCollRepo->findByPid($pid, array('name' => 'asc'));

        return $this->render('WBQbankBundle:IndicatorsBack:indicatorCollectionsList.html.twig', array(
            'indCollections' => $indCollections,
            'pid' => $pid
        ));
    }
}
