<?php
/**
 *   This file is part of the maishapay-php-client
 * 
 *   @copyright   Bernard ngandu <ngandubernard@gmail.com>
 *   @link    https://github.com/bernard-ng/maishapay-php-client
 *
 *   For the full copyright and license information, please view the LICENSE
 *   file that was distributed with this source code.
 */

namespace Ng\Maishapay;

use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\StreamInterface;
use function GuzzleHttp\json_decode;



/**
 * Class Client
* @author bernard-ng <ngandubernard@gmail.com>
*/
class Client {

    /**
     * the client api key
     *
     * @var string
     */
    private $apikey;

    /**
     * guzzleclient
     *
     * @var GuzzleClient
     */
    private $client;

    /**
     * maishapay redirect url
     *
     * @var string
     */
    private $redirectUrl;


    /**
     * The api url
     */
    private const API_URL = "https://maishapay.online/maishapay/webapp2/";


    /**
     * Set up the client
     * @param string $apikey
     */
    public function __construct(string $apikey)
    {
        $this->apikey = $apikey;
    }


    /**
     * Retrieve the $client
     * @return GuzzleClient
     */
    public function getClient(): GuzzleClient
    {
        if (is_null($this->client)) {
            $this->client = new GuzzleClient();
        }
        return $this->client;
    }


    /**
     * merge request data with the apikey
     *
     * @param array $data
     * @return array
     */
    private function formParams(array $data): array
    {
        return array_merge($data, ['client_api_key', $this->apikey]);
    }


    /**
     * Retriefe the Api redirect Url
     *
     * @throws \RuntimeException when data are invalid or apikey missing
     * @return null|string
     */
    public function getRedirectUrl(array $config = [])
    {
        $response = $this->getClient()->request('POST', self::API_URL, [
            'form_params' => $this->formParams($config)
        ]);

        $status = $response->getStatusCode();
        $data = ($response instanceof StreamInterface)? (string)$response->getBody() : $response->getBody();
        $data = json_decode($data);
    
        if ($status !== 200) {
            throw new \RuntimeException($data->message);
        } else {
            $this->redirectUrl = $data->message;
        }        
    }


    /**
     * confirm a transaction
     *
     * @param boolean $success
     * @param string $message
     * @return void
     */
    public function confirm(bool $success, string $message = ""): void 
    {
        $this->getClient()->request('POST', self::API_URL, [
            'form_params' => $this->formParams(compact('success', 'message'))
        ]);
    }
}
