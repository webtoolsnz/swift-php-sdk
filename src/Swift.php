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
use GuzzleHttp\Message\ResponseInterface;
use webtoolsnz\Swift\Actions\CampaignList;
use webtoolsnz\Swift\Actions\Media;
use webtoolsnz\Swift\Actions\RecipientCreate;
use webtoolsnz\Swift\Actions\RecipientDelete;
use webtoolsnz\Swift\Actions\RecipientView;
use webtoolsnz\Swift\Exceptions\AuthenticationException;
use webtoolsnz\Swift\Exceptions\DataValidationException;
use webtoolsnz\Swift\Exceptions\SwiftException;
use webtoolsnz\Swift\Resources\Campaign;
use webtoolsnz\Swift\Resources\Recipient;

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
            $this->endPoint . '/' . $method->getRequestPath(),
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

        if (in_array($response->getStatusCode(), [200, 201, 204], true)) {
            return $method->processResponse($response);
        }

        return $this->processError($response);
    }

    /**
     * @param ResponseInterface $response
     * @throws AuthenticationException
     * @throws DataValidationException
     * @throws SwiftException
     */
    private function processError(ResponseInterface $response)
    {
        $body = $response->getBody()->getContents();
        $json = json_decode($body);
        $message = isset($json->message) ? $json->message : $body;

        switch ($response->getStatusCode()) {
            case 401:
            case 403:
                throw new AuthenticationException($message);
            case 422:
                throw new DataValidationException(json_encode($message));
        }

        throw new SwiftException($message, $response->getStatusCode());
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

    /**
     * @param  integer $id
     * @return Recipient
     */
    public function getRecipient($id)
    {
        return $this->execute(new RecipientView($id));
    }

    /**
     * @param Recipient $resource
     * @return Recipient
     */
    public function createRecipient(Recipient $resource)
    {
        return $this->execute(new RecipientCreate($resource));
    }

    /**
     * @param $id
     */
    public function deleteRecipient($id)
    {
        $this->execute(new RecipientDelete($id));
    }

    /**
     * @param $file
     * @return \webtoolsnz\Swift\Resources\Media
     */
    public function getMedia($file)
    {
        return $this->execute(new Media($file));
    }
}
