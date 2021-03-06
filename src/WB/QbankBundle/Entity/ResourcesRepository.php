<?php

namespace WB\QbankBundle\Entity;

use Doctrine\ORM\EntityRepository;


/**
 * ResourcesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ResourcesRepository extends EntityRepository
{
    public function searchResources($published, $keyword, $excludedIds)
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder();
        $query
            ->select('c')
            ->from('WBQbankBundle:Resources', 'c')
            ->orderBy('c.title', 'ASC');

        if ($keyword) {
            $query
                ->where(
                    $query->expr()->orX(
                        $query->expr()->like('c.title', ':keyword'),
                        $query->expr()->like('c.description', ':keyword')
                    )
                )
                ->setParameter('keyword', "%" . $keyword . "%");
        }

        if (false !== $published) {
            $query
                ->andWhere("c.published = :published")
                ->setParameter('published', $published);
        }

        if (!empty($excludedIds)) {
            $query
                ->andWhere($query->expr()->notIn('c.id', ':excludedIds'))
                ->setParameter('excludedIds', $excludedIds);
        }

        $q = $query->getQuery();
        return $q->getResult();
    }

}
