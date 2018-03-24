<?php
namespace Gwsn\CacheUtil;

use Illuminate\Support\Facades\Cache;

class CacheUtil {


    /**
     * Set CacheTime (default: 1 hour)
     *
     * @var int $cacheTime
     */
    private $cacheTime = ( 1 * 60 * 60 );

    /**
     * @return int
     */
    public function getCacheTime()
    : int {
        return $this->cacheTime;
    }

    /**
     * @param int $cacheTime
     */
    public function setCacheTime( int $cacheTime ) {
        $this->cacheTime = $cacheTime;
    }

    /**
     * Check if the request is cached
     *
     * @return mixed
     */
    public function has($cacheKey = null) {
        return Cache::has( $cacheKey );
    }

    /**
     * Get the request from the cache
     *
     * @return mixed
     */
    public function get($cacheKey = null, $default = null) {
        if(!Cache::has($cacheKey)) {
            return $default;
        }
        return unserialize( Cache::get( $cacheKey ) );
    }

    /**
     * Set the data to the cache
     *
     * @param mixed|Response $data
     *
     * @return mixed
     */
    public function set( $cacheKey = null, $data = null, $cacheTime = null) {
        if($cacheTime !== null) {
            $this->setCacheTime($cacheTime);
        }
        if(Cache::has($cacheKey)) {
            Cache::forget($cacheKey);
        }

        return Cache::put( $cacheKey, serialize( $data ), $this->getCacheTime() );
    }

    /**
     * @param null $cacheKey
     *
     * @return bool
     */
    public function forget($cacheKey = null) {
        if(Cache::has($cacheKey)) {
            Cache::forget($cacheKey);
            return true;
        }
        return false;
    }
}