<?php
/**
 * This file is part of the webtoolsnz\Swift library
 *
 * @license http://opensource.org/licenses/MIT
 * @link https://github.com/webtoolsnz/swift-php-sdk
 * @package webtoolsnz/swift-sdk
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace webtoolsnz\Swift;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Client;
use webtoolsnz\Swift\Actions\CampaignList;
use webtoolsnz\Swift\Exceptions\SwiftException;
use webtoolsnz\Swift\Resources\Campaign;

/**
 * Class Swift
 * @package webtoolsnz\Swift
 */
class Swift
{
    /**
     * @var \GuzzleHttp\ClientInterface
     */
    private $http;

    /**
     * @var
     */
    private $key;

    /**
     * @var
     */
    private $endPoint;

    /**
     * Swift constructor.
     * @param $endpoint
     * @param $key
     * @param ClientInterface|null $httpClient
     */
    public function __construct($endpoint, $key, ClientInterface $httpClient = null)
    {
        if (null === $httpClient) {
            $httpClient = new Client();
        }

        $this->key = $key;
        $this->endPoint = $endpoint;
        $this->http = $httpClient;
    }

    /**
     * @param ActionInterface $method
     * @return \GuzzleHttp\Message\Request|\GuzzleHttp\Message\RequestInterface
     */
    private function createRequest(ActionInterface $method)
    {
        return $this->http->createRequest(
            $method->getRequestMethod(),
            $this->endPoint . '/' .$method->getRequestPath(),
            array_merge_recursive([
                'exceptions' => false,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Authorization' => sprintf('Bearer %s', $this->key),
                ],
            ], $method->getRequestOptions())
        );
    }

    /**
     * @param ActionInterface $method
     * @return mixed
     */
    private function execute(ActionInterface $method)
    {
        $response = $this->http->send($this->createRequest($method));

        if ($response->getStatusCode() !== 200) {
            $json = json_decode($response->getBody()->getContents());
//            if (isset($json->error) && is_array($json->error->errors)) {
//                $this->assertInvalidKey($json);
//                $this->assertInvalidValue($json);
//            } // @codeCoverageIgnore
            throw new SwiftException($response->getBody());
        }

        return $method->processResponse($response);
    }

    /**
     * Return a list of campaigns associated with the current account.
     *
     * @return Campaign[]
     */
    public function getCampaigns()
    {
        return $this->execute(new CampaignList());
    }
}
