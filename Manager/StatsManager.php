<?php

namespace Tristanbes\ElophantBundle\Manager;

use Doctrine\ORM\EntityManager;

use Tristanbes\ElophantBundle\Entity\ApiCall;

class StatsManager
{

    protected $entityManager;

    /**
     * Constructor
     *
     * @param EntityManager $manager Doctrine Entity Manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->entityManager = $manager;
    }

    /**
     * Records a failed request to the API
     */
    public function addFail()
    {
        $apicall = $this->getCurrentTracking();

        if ($apicall) {
            $apicall->addFail();
        } else {
            $apicall = new ApiCall;
            $apicall->setFail(1);
        }

        $this->entityManager->persist($apicall);
        $this->entityManager->flush();
    }

    /**
     * Records a success request to the API
     */
    public function addSuccess()
    {
        $apicall = $this->getCurrentTracking();

        if ($apicall) {
            $apicall->addSuccess();
        } else {
            $apicall = new ApiCall;
            $apicall->setSuccess(1);
        }

        $this->entityManager->persist($apicall);
        $this->entityManager->flush();
    }

    /**
     * Tracks requests loaded from cache
     */
    public function addFromCache()
    {
        $apicall = $this->getCurrentTracking();

        if ($apicall) {
            $apicall->addFromCache();
        } else {
            $apicall = new ApiCall;
            $apicall->setFromCache(1);
        }

        $this->entityManager->persist($apicall);
        $this->entityManager->flush();

    }

    /**
     * Gets the current tracking
     *
     * @return null|ApiCall
     */
    public function getCurrentTracking()
    {
        $repository = $this->entityManager->getRepository("TristanbesElophantBundle:ApiCall");

        return $repository->getDailyStatistics();
    }

}
