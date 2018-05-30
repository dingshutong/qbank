<?php
namespace WB\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{

    public function getUsers()
    {

        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT u
                FROM WBUserBundle:User u
                ORDER BY u.id ASC'
            );
        return $query->getResult();
    }

    public function searchUsers($keyword)
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder();
        $query
            ->select('u')
            ->from('WBUserBundle:User', 'u')
            ->orderBy('u.username', 'ASC');

        if ($keyword) {
            $query
                ->leftJoin('u.companyId', 'c')
                ->leftJoin('u.countryId', 'r')
                ->where(
                    $query->expr()->orX(
                        $query->expr()->like('u.username', ':keyword'),
                        $query->expr()->like('u.email', ':keyword'),
                        $query->expr()->like('u.firstName', ':keyword'),
                        $query->expr()->like('u.lastName', ':keyword'),
                        $query->expr()->like('u.phone', ':keyword'),
                        $query->expr()->like('r.name', ':keyword'),
                        $query->expr()->like('c.name', ':keyword')
                    )
                )
                ->setParameter('keyword', "%" . $keyword . "%");
        }

        $q = $query->getQuery();
        return $q->getResult();
    }

} 