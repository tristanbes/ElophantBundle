<?php

namespace Tristanbes\ElophantBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ApiCall
 *
 * @ORM\Table(name="api_call")
 * @ORM\Entity(repositoryClass="Tristanbes\ElophantBundle\Entity\ApiCallRepository")
 */
class ApiCall
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="success", type="integer", nullable=true)
     */
    private $success = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="fail", type="integer", nullable=true)
     */
    private $fail = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="from_cache", type="integer", nullable=true)
     */
    private $fromCache = 0;

    public function __construct()
    {
        $date = new \DateTime;
        $date->format('Y-m-d');

        $this->date = $date;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return ApiCall
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set success
     *
     * @param integer $success
     * @return ApiCall
     */
    public function setSuccess($success)
    {
        $this->success = $success;

        return $this;
    }

    /**
     * Get success
     *
     * @return integer
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * Increment success value
     *
     * @return integer
     */
    public function addSuccess()
    {
        return $this->setSuccess($this->getSuccess() + 1);
    }

    /**
     * Set fail
     *
     * @param integer $fail
     * @return ApiCall
     */
    public function setFail($fail)
    {
        $this->fail = $fail;

        return $this;
    }

    /**
     * Get fail
     *
     * @return integer
     */
    public function getFail()
    {
        return $this->fail;
    }

    /**
     * Increment fail value
     *
     * @return integer
     */
    public function addFail()
    {
        $this->setFail($this->getFail() + 1);
    }

    /**
     * Set fail
     *
     * @param integer $fromCache
     * @return ApiCall
     */
    public function setFromCache($fromCache)
    {
        $this->fromCache = $fromCache;

        return $this;
    }

    /**
     * Get fromCache
     *
     * @return integer
     */
    public function getFromCache()
    {
        return $this->fromCache;
    }

    /**
     * Increment fromCache value
     *
     * @return integer
     */
    public function addfromCache()
    {
        $this->setFromCache($this->getFromCache() + 1);
    }
}
