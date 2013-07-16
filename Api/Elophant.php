<?php

namespace Tristanbes\ElophantBundle\Api;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\CurlException;
use Guzzle\Http\Exception\BadResponseException;

use Tristanbes\ElophantBundle\Manager\StatsManager;

class Elophant
{
    protected $client;
    protected $apiKey;
    protected $statsManager;
    protected $ignoreCache = false;

    /**
     * Constructor
     *
     * @param string $apiKey The elophant Api Key
     */
    public function __construct(StatsManager $manager, Client $client, $cache = null, $apiKey)
    {
        $this->client       = $client;
        $this->cache        = $cache;
        $this->apiKey       = $apiKey;
        $this->statsManager = $manager;
    }

    /**
     * Returns a summoner's accountId, summonerId, account level, and profile icon id.
     *
     * @param string $region The Region
     * @param string $name   The summonerName
     *
     * @return json
     */
    public function getSummonerByName($region, $name)
    {
        $url = $region."/summoner/".urlencode($name);

        $data = $this->doRest($url);

        return $data;
    }

    /**
     * Returns a summoner's accountId, summonerId, account level, and profile icon id.
     *
     * @param string $region The Region
     *
     * @return json
     */
    public function getStats($region, $accountId, $season = 'current')
    {
        if (!$accountId) {
            return;
        }

        $url = $region."/player_stats/".$accountId."/".$season;

        $data = $this->doRest($url);

        return $data;
    }

    /**
     * Returns team stats for a given team name.
     *
     * @param string $teamName The team name
     *
     * @return json
     */
    public function getTeamStats($teamName, $region = 'euw')
    {
        if (!$region || $region == '') {
            $region = 'euw';
        }

        $url = $region."/find_team/".urlencode($teamName);

        $data = $this->doRest($url);

        return $data;
    }

    public function getLeagues($region, $accountId)
    {
        if (!$accountId) {
            return;
        }

        $url = $region."/leagues/".$accountId;

        $data = $this->doRest($url);

        return $data;
    }

    /**
     * Do the request (or fetch the cache)
     *
     * @param string $url The url to call
     *
     * @return Json
     */
    public function doRest($url)
    {
        $cacheKey = $this->getCacheKey($url);

        // Is the response already available from cache ?
        if ($this->cache && $this->cache->contains($cacheKey)) {
            if ($this->hasIgnoreCache() === false) {
                $cachedResponse = unserialize($this->cache->fetch($cacheKey));
                $this->statsManager->addFromCache();

                return $cachedResponse;
            } else {
                $this->cache->delete($cacheKey);
            }
        }

        $request = $this->client->get($url);

        $query = $request->getQuery();

        $query->add('key', $this->apiKey);

        $data = $request->send()->json();

        $this->statsManager->addSuccess();

        // Saves the data in the cache
        if ($this->cache && $this->hasIgnoreCache() === false) {
            $this->cache->save($cacheKey, serialize($data), $this->getTtl());
        }

        return $data;
    }

    /**
     * setCache provider
     *
     * @param Cache $cache The cache
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
    }

    /**
     * Set TTL for the cache
     *
     * @param integer $ttl Time in seconds
     */
    public function setTtl($ttl)
    {
        $this->ttl = $ttl;
    }

    /**
     * Returns the TTL
     *
     * @return integer
     */
    public function getTtl()
    {
        return $this->ttl;
    }

    /**
     * Setter for the noCache policy
     *
     * @param Boolean $noCache If the API call will ignore the cache or not
     */
    public function setIgnoreCache($ignoreCache)
    {
        $this->ignoreCache = $ignoreCache;
    }

    /**
     * Returns the cache policy
     *
     * @return Boolean
     */
    public function hasIgnoreCache()
    {
        return $this->ignoreCache;
    }

    /**
     * Gets the cache key
     *
     * @param string $url The Url
     *
     * @return string
     */
    private function getCacheKey($url)
    {
        return md5($url);
    }
}
