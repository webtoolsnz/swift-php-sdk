<?php

namespace webtoolsnz\Swift\Actions;

use GuzzleHttp\Message\ResponseInterface;
use webtoolsnz\Swift\ActionInterface;
use webtoolsnz\Swift\Exceptions\SwiftException;
use webtoolsnz\Swift\Resources\Campaign;
use webtoolsnz\Swift\Resources\Recipient;

/**
 * Class CampaignList
 * @package webtoolsnz\Swift\Actions
 */
class RecipientView implements ActionInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * RecipientView constructor.
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getRequestMethod()
    {
        return 'GET';
    }

    /**
     * @return string
     */
    public function getRequestPath()
    {
        return 'recipient/view';
    }

    /**
     * @return array
     */
    public function getRequestOptions()
    {
        return ['query' => ['id' => $this->id]];
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
