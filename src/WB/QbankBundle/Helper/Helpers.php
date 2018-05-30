<?php

namespace WB\QbankBundle\Helper;

use Doctrine\ORM\EntityManager;

class Helpers
{
    private $em;
    private $parentGroups;
    private $parentCollections;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Recursive function for getting tree subitems
     */
    public function getSubitems($pid, $groupsParents, $groupsItems)
    {
        $subitems = array_key_exists($pid, $groupsParents) ? $groupsParents[$pid] : false;
        $subSubItems = array();

        if ($subitems) {
            if (count($subitems)) {
                foreach ($subitems as $key => $subitem) {
                    $subSubItems[] = array(
                        'id' => $subitem->getId(),
                        'name' => $subitem->getName(),
                        'published' => $subitem->getPublished(),
                        'sub' => $this->getSubitems($subitem->getId(), $groupsParents, $groupsItems),
                        'items' => array_key_exists($subitem->getId(), $groupsItems) ? $groupsItems[$subitem->getId()] : false
                    );
                }
            }
        }

        return $subSubItems;
    }


    /**
     * Recursive function for getting parent indicator groups
     */
    public function getParentGroups($grupId, $entity)
    {
        $group = $this->em->getRepository($entity)
            ->find($grupId);

        if (count($group)) {
            $this->parentGroups[] = array(
                'grpId' => $group->getId(),
                'grpName' => $group->getName()
            );
            $this->getParentGroups($group->getPid(), $entity);
        }

        return array_reverse($this->parentGroups);
    }

    /**
     * Recursive function for getting parent collections
     */
    public function getParentCollections($collectId)
    {
        $collection = $this->em->getRepository('WBQbankBundle:IndicatorCollections')
            ->find($collectId);

        if (count($collection)) {
            $this->parentCollections[] = array(
                'collId' => $collection->getId(),
                'collName' => $collection->getName()
            );
            $this->getParentCollections($collection->getPid());
        }

        return array_reverse($this->parentCollections);
    }

    public function resetParentGroups()
    {
        $this->parentGroups = array();
    }

    public function resetParentCollections()
    {
        $this->parentCollections = array();
    }

    public function sortGrpRef($a, $b)
    {
        if ($a['weight'] < $b['weight']) {
            return -1;
        } else {
            return 1;
        }
    }


    public function cleanUpTree($grpTree)
    {
        if (count($grpTree['sub'])) {
            foreach ($grpTree['sub'] as $key => $branch) {

                $grpTree['sub'][$key] = $branch = $this->cleanUpTree($branch);

                if ((count($branch['sub']) == 0) && (false === $branch['items'])) {
                    unset($grpTree['sub'][$key]);
                }
            }
        }

        return $grpTree;
    }

    public function countTree($grpTree, $numGroups = 0)
    {

        if (isset($grpTree['sub'])) {
            if ($num = count($grpTree['sub'])) {
                $numGroups += $num;
                foreach ($grpTree['sub'] as $branch) {
                    $numGroups = $this->countTree($branch, $numGroups);
                }
            }
        }
        return $numGroups;
    }

    public function makeClassificationTree($showPublishedOnly, $search, $excludedIds = array())
    {
        $classGroupsRepo = $this->em
            ->getRepository('WBQbankBundle:ClassificationGroups');

        // groups at zero level
        $startLevelGroups = (!$showPublishedOnly)
            ? $classGroupsRepo->findByPid(0, array( 'name' => 'asc'))
            : $classGroupsRepo->findBy(array('pid' => 0, 'published' => true), array('name' => 'asc'));

        /* creating an array of groups and related classifications */
        $classRepository = $this->em
            ->getRepository('WBQbankBundle:Classifications');

        $paramPublished = $showPublishedOnly ? 1 : false;

        $allClassifications = $classRepository->searchClassifications("NOT NULL", $paramPublished, $search, $excludedIds);
        $allReferences = $this->em->getRepository('WBQbankBundle:ClassificationGrpRef')->getClassificationsReferences($showPublishedOnly, $search, $excludedIds);

        $groupsClassifications = array();
        foreach ($allReferences as $reference) {
            $groupsClassifications[$reference->getClassificationGroupId()->getId()][] = $reference->getClassificationId();
        }

        $groupsParents = array();

        $classificationGroups = (!$showPublishedOnly)
            ? $classGroupsRepo->findBy(array(), array( 'name' => 'asc'))
            : $classGroupsRepo->findByPublished(true, array( 'name' => 'asc'));

        if ($countGroups = count($classificationGroups)) {
            foreach ($classificationGroups as $classificationGroup) {
                $groupsParents[$classificationGroup->getPid()][] = $classificationGroup;
            }
        }

        // make groups tree
        $grpTree = array();
        $i = 0;
        foreach ($startLevelGroups as $group) {
            $grpTree['sub'][] = array(
                'id' => $group->getId(),
                'name' => $group->getName(),
                'published' => $group->getPublished(),
                'sub' => $this->getSubitems($group->getId(), $groupsParents, $groupsClassifications),
                'items' => array_key_exists($group->getId(), $groupsClassifications) ? $groupsClassifications[$group->getId()] : false
            );
            $i++;
        }

        return $grpTree;

    }

    public function makeQuestionnaireTree($showPublishedOnly, $search, $excludedIds = array())
    {
        $questGroupsRepo = $this->em
            ->getRepository('WBQbankBundle:QuestionnaireGroups');

        // groups at zero level
        $startLevelGroups = (!$showPublishedOnly)
            ? $questGroupsRepo->findByPid(0, array('weight' => 'asc', 'name' => 'asc'))
            : $questGroupsRepo->findBy(array('pid' => 0, 'published' => true), array('weight' => 'asc', 'name' => 'asc'));

        /* creating an array of groups and related questionnaires */
        $questRepository = $this->em
            ->getRepository('WBQbankBundle:QuestionnaireModules');

        $paramPublished = $showPublishedOnly ? 1 : false;

        $allQuestionnaires = $questRepository->searchQuestionnaires("NOT NULL", $paramPublished, $search, $excludedIds);
        $allReferences = $this->em->getRepository('WBQbankBundle:QuestionnaireGroupRelModules')->getQuestionnairesReferences($showPublishedOnly, $search, $excludedIds);

        $groupsQuestionnaires = array();
        foreach ($allReferences as $reference) {
            $groupsQuestionnaires[$reference->getQuestGroupId()->getId()][] = $reference->getQuestModuleId();
        }

        $groupsParents = array();

        $questionnaireGroups = (!$showPublishedOnly)
            ? $questGroupsRepo->findBy(array(), array('weight' => 'asc', 'name' => 'asc'))
            : $questGroupsRepo->findByPublished(true, array('weight' => 'asc', 'name' => 'asc'));

        if ($countGroups = count($questionnaireGroups)) {
            foreach ($questionnaireGroups as $questionnaireGroup) {
                $groupsParents[$questionnaireGroup->getPid()][] = $questionnaireGroup;
            }
        }

        // make groups tree
        $grpTree = array();
        $i = 0;
        foreach ($startLevelGroups as $group) {
            $grpTree['sub'][] = array(
                'id' => $group->getId(),
                'name' => $group->getName(),
                'published' => $group->getPublished(),
                'sub' => $this->getSubitems($group->getId(), $groupsParents, $groupsQuestionnaires),
                'items' => array_key_exists($group->getId(), $groupsQuestionnaires) ? $groupsQuestionnaires[$group->getId()] : false
            );
            $i++;
        }

        return $grpTree;

    }

    public function removeEmptyGroups($groups){
        foreach ($groups as $key => $group){
            if ( count($group["sub"]) < 1 && $group["items"] == false){
                unset($groups[$key]);
            }
        }
        return $groups;
    }
    public function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}


}
