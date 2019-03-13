<?php
namespace SS4form\App;

use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use Psr\SimpleCache\CacheInterface;
use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\Core\Injector\Injector;

use SS4form\App\BusStopGateway;

/**
 * Provides common calls to the {@link WorkplaceGateway}.
 *
 * The {@link WorkplaceGateway} endpoints return JSON responses, this service is used
 *
 * @see {@link WorkplaceGateway}.
 *
 * @package workplace-service
 */
class BusStopService
{   
    /**
     * @var BusStopService
     */
    public $BusStopGateway;

    /**
     * @var array
     */
    private static $dependencies = [
        'WorkplaceGateway' => '%$' . WorkplaceGateway::class,
    ];

    public function getAllBusStop()
    {
        // get the cache for this service
        // $cache = Injector::inst()->get(CacheInterface::class . '.nztaWorkplace');
        // $cacheKey = md5('BusStopService');

        // attempt to retrieve Array of groups from cache
        if (!($groups = $cache->get($cacheKey))) {
            $response = $this->BusStopGateway->getAllStops();
            $stops = [];
            $items = json_decode($response)->data;

            if (is_array($items)) {
                foreach ($items as $item) {
                    if (isset($item->id) && isset($item->name)) {
                        $stops[$item->id] = $item->name;
                    }
                }
            }

            // otherwise we retrieve the groups and store to the cache as an array
            $cache->set($cacheKey, $groups, Config::inst()->get(BusStopService::class, 'cache_life_cycle'));
        }
        return $groups;

    }

    public function getAllBusStopDetails()
    {
        // get the cache for this service
        // $cache = Injector::inst()->get(CacheInterface::class . '.nztaWorkplace');
        // $cacheKey = md5('BusStopServiceStops');

        // attempt to retrieve Array of groups from cache
        if (!($stops = $cache->get($cacheKey))) {
            $response = $this->BusStopGateway->getAllStops();
            $stops = [];
            $items = json_decode($response)->data;

            if (is_array($items)) {
                foreach ($items as $item) {
                    if (isset($item->id) && isset($item->name)) {
                        $stops[$item->id] = $item->name;
                    }
                }
            }

            // otherwise we retrieve the busStop Service to the cache as an array
            $cache->set($cacheKey, $stops, Config::inst()->get(BusStopService::class, 'busstop_lifetime'));
        }
        return $groups;
    }
}