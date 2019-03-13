<?php

namespace SS4form\App\Controllers;

use SilverStripe\ORM\ArrayList;

use SilverStripe\ORM\DataList;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\View\ArrayData;

use PageController;

class ServicePageController extends PageController
{
    /**
     *
     * @return ArrayList
     */
    public function getServicepagePosts()
    {
        $posts = ArrayList::create();
        $service = $this->BusStopService->getAllBusStop();
        $response = $service->request("datastore_search?resource_id=205a2d33-18c9-402e-9f58-40f7c5243f36&limit=5");
        
        if($response && $response->getStatusCode() == 200 ) {
            $data = json_decode($response->getBody());
            
            foreach($posts as $post) {
                $b = DataObject::create();

                $b->STOPID = $data->STOPID;
                $b->STOPNAME = $data->STOPNAME;
                $b->STOPLAT = $data->STOPLAT;
                $b->STOPLON = $data->STOPLON;

                $posts->push($b);
            }
        }
        
        return $posts;
    }
    
}
