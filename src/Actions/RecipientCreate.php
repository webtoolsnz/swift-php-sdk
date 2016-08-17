<?php

namespace webtoolsnz\Swift\Actions;

use GuzzleHttp\Message\ResponseInterface;
use webtoolsnz\Swift\ActionInterface;
use webtoolsnz\Swift\Exceptions\SwiftException;
use webtoolsnz\Swift\Resources\Recipient;

/**
 * Class RecipientCreate
 * @package webtoolsnz\Swift\Actions
 */
class RecipientCreate implements ActionInterface
{
    /**
     * @var Recipient
     */
    private $resource;

    /**
     * RecipientCreate constructor.
     * @param Recipient $resource
     */
    public function __construct(Recipient $resource)
    {
        $this->resource = $resource;
    }

    /**
     * @return string
     */
    public function getRequestMethod()
    {
        return 'POST';
    }

    /**
     * @return string
     */
    public function getRequestPath()
    {
        return 'recipient/create';
    }

    /**
     * @return array
     */
    public function getRequestOptions()
    {
        return ['body' => json_encode($this->resource)];
    }

    /**
     * @param ResponseInterface $response
     * @return Recipient
     */
    public function processResponse(ResponseInterface $response)
    {
        $obj = json_decode($response->getBody()->getContents());
        return Recipient::createFromJson($obj);
    }
}
