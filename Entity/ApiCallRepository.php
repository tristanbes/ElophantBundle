<?php

namespace Tristanbes\ElophantBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ApiCallRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ApiCallRepository extends EntityRepository
{

    /**
     * Get the current track of api calls in a daily basis
     *
     * @return null|row
     */
    public function getDailyStatistics()
    {
        $date = new \DateTime();
        $date = $date->format('Y-m-d');

        $builder = $this->createQueryBuilder("a");

        $builder
            ->where('a.date = :date')
            ->setParameter('date', $date);

        $result = $builder->getQuery()->getOneOrNullResult();

        return $result;
    }

    /**
     * Returns X rows of statistics
     *
     * @param integer $limit The limit of displayed days
     *
     * @return array
     */
    public function getStatsPerDay($limit)
    {
        $builder = $this->createQueryBuilder("a");

        $builder
            ->orderBy('a.date', 'DESC')
            ->setMaxResults($limit);

        $result = $builder->getQuery()->execute();

        return $result;
    }

}
