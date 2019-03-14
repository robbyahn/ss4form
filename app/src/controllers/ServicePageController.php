<?php

namespace SS4form\App\Controllers;

use SilverStripe\Core\Environment;
use SilverStripe\Core\Injector\Injector;

use SS4form\App\BusStopService;

use PageController;

class ServicePageController extends PageController
{
    public function init() {
        $this->getList();

        parent::init();
    }
    
    
    /**
     *
     * @return ArrayList
     */
    public function getList()
    {
        $BusStopService = Injector::inst()->get(BusStopService::class)->getAllBusStop();
        
        return $BusStopService;
    }
}
