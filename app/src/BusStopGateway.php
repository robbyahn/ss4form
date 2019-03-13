<?php
namespace SS4form\App;

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Injector\Injector;
use GuzzleHttp\Exception\ClientException;
use SilverStripe\Core\Environment;

/**
 * Handles the direct calls to the Workplace API.
 * The calls are made to endpoints using a {@link Client}.
 */
class BusStopGateway
{  
    
    /**
     * https://catalogue.data.govt.nz/api/3/action/datastore_search?resource_id=205a2d33-18c9-402e-9f58-40f7c5243f36&limit=5
     * @return null|string
     */
    public function getAllStops()
    {   
        return $this->call('get', sprintf(
            '?limit=%d',
            Environment::getEnv('SS4form_ID'),
            Config::inst()->get(BusStopGateway::class)
        ));
    }

    
    /**
     * Make a REST call to the Workplace API.
     *
     * @param String $type The type should be post or get
     * @param String $parameters The rest parameters to call.
     *
     * @return null|string JSON representation of the response.
     * @throws \Exception
     */
    public function call($type, $parameters)
    {
        $client = new Client([
            'base_uri' => Environment::getEnv('https://catalogue.data.govt.nz/api/3/'),
            'headers'  => [
                'Authorization' => sprintf('Bearer %s', Environment::getEnv('token_goes_here'))
            ]
        ]);

        try {
            $proxy = [];

            if (Environment::getEnv('SS_OUTBOUND_PROXY') && Environment::getEnv('SS_OUTBOUND_PROXY_PORT')) {
                $proxy = Environment::getEnv('SS_OUTBOUND_PROXY');
                $proxyPort = Environment::getEnv('SS_OUTBOUND_PROXY_PORT');
                $proxy = [
                    'proxy' => [
                        'http'  => sprintf('tcp://%s:%s', $proxy, $proxyPort), // Use this proxy with "http"
                        'https' => sprintf('tcp://%s:%s', $proxy, $proxyPort), // Use this proxy with "https",
                    ],
                ];
            }

            if ($type == 'get') {
                $response = $client->get($parameters, $proxy);
            } elseif ($type == 'post') {
                $response = $client->post($parameters, $proxy);
            } else {
                return null;
            }

            if ($response->getStatusCode() === 200) {
                return $response->getBody()->getContents();
            } else {
                throw new \Exception(sprintf(
                    'StatusCode: %s. StatusDescription: %s.',
                    $response->getStatusCode(),
                    $response->getStatusDescription()
                ));
            }

        } catch (ClientException $e) {
            $response = json_decode($e->getResponse()->getBody()->getContents());

            // Check exception error code is 100 when user not registered with workplace.
            // And not going to log any exceptions with error code 100
            if (isset($response->error->code) && $response->error->code == 100) {
                return null;
            }

            Injector::inst()->get(LoggerInterface::class)->error(
                sprintf(
                    'Error in WorkplaceGateway::call(%s). %s',
                    $parameters,
                    $e->getMessage()
                ),
                [
                    'Body' => $e
                ]
            );
        } catch (\Exeception $e) {
            Injector::inst()->get(LoggerInterface::class)->error(
                sprintf(
                    'Error in WorkplaceGateway::call(%s). %s',
                    $parameters,
                    $e->getMessage()
                ),
                [
                    'Body' => $e
                ]
            );
        }

        return null;
    }
}