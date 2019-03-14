<?php
namespace SS4form\App;

use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Injector\Injector;

use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\ORM\DataObject;

use SS4form\App\BusStopGateway;

/**
 * Provides common calls to the {@link BusStopGateway}.
 *
 * The {@link BusStopGateway} endpoints return JSON responses, this service is used
 *
 * @see {@link BusStopGateway}.
 *
 */

class BusStopService
{   
    public $BusStopGateway;

    public function getAllBusStop()
    {
        $posts = ArrayList::create();
        $response = Injector::inst()->get(BusStopGateway::class)->getAllStops();
       
        $stops = [];
        $data = json_decode($response);

        foreach($data->result->records as $item) {
            $bs = DataObject::create();
            
            $bs->STOPID = $item->STOPID;
            $bs->STOPNAME = $item->STOPNAME;
            $bs->STOPLAT = $item->STOPLAT;
            $bs->STOPLON = $item->STOPLON;
            
            $posts->push($bs);
        }

        return $posts;
    }

}