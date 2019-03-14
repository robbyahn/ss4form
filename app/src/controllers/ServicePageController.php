<?php

namespace SS4form\App\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

use Psr\Log\LoggerInterface;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Injector\Injector;

use SilverStripe\Core\Environment;

use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\View\ArrayData;

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
        $posts = ArrayList::create();

        $client = new Client();
        $response = $client->request('GET', 'https://catalogue.data.govt.nz/api/3/action/datastore_search?resource_id=205a2d33-18c9-402e-9f58-40f7c5243f36&limit=5');
        
        //echo $response->getStatusCode(); # 200
        //echo $response->getHeaderLine('content-type'); # 'application/json; charset=utf8'
        //echo $response->getBody(); # '{"id": 1420053, "name": "guzzle", ...}'

        // $service = $this->BusStopService->getAllBusStop();
        // $response = $service->request("https://catalogue.data.govt.nz/api/3/action/datastore_search?resource_id=205a2d33-18c9-402e-9f58-40f7c5243f36&limit=5");
        
        $stops = [];
        // $items = json_decode($response->getBody())->data;

        // var_dump($response->getBody());     //stream

        $data = json_decode($response->getBody());
        //var_dump( $data['records']);

        $stops = ArrayList::create();

        // echo '<pre>' . print_r($data, true) . '</pre>';
        //var_dump($data->result->records);

        foreach($data->result->records as $item) {
            $b = DataObject::create();
            
            $b->STOPNAME = $item->STOPID;
            $b->OBJECTID = $item->STOPNAME;
            
            $stops->push($b);
        }

        var_dump($stops);       //ArrayList
        
        return $posts;
    }
    
}
