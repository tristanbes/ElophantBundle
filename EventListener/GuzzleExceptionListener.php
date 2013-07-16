<?php

namespace Tristanbes\ElophantBundle\EventListener;

use Guzzle\Http\Exception\BadResponseException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

use Tristanbes\ElophantBundle\Manager\StatsManager;

/**
 * Class GuzzleExceptionListener
 */
class GuzzleExceptionListener
{
    private $statsManager;
    private $fail = 0;

    /**
     * Constructor
     *
     * @param StatsManager $manager Doctrine Entity Manager
     */
    public function __construct(StatsManager $manager)
    {
        $this->statsManager = $manager;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getException();

        if ($exception instanceof BadResponseException) {
            $this->fail = 1;
            $response   = new JsonResponse(array('success' => false));
            $event->setResponse($response);
        }
    }

    public function onKernelTerminate(PostResponseEvent $event)
    {
        if ($this->fail == 0) {
            return;
        }

        $this->statsManager->addFail();
    }

}
