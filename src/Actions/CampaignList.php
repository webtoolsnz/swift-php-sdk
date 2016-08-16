<?php

namespace webtoolsnz\Swift\Actions;

use GuzzleHttp\Message\ResponseInterface;
use webtoolsnz\Swift\ActionInterface;
use webtoolsnz\Swift\Exceptions\SwiftException;
use webtoolsnz\Swift\Resources\Campaign;

/**
 * Class CampaignList
 * @package webtoolsnz\Swift\Actions
 */
class CampaignList implements ActionInterface
{
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
        return 'campaign';
    }

    /**
     * @return array
     */
    public function getRequestOptions()
    {
        return [];
    }

    /**
     * @param ResponseInterface $response
     * @return Campaign[]
     */
    public function processResponse(ResponseInterface $response)
    {
        $body = $response->getBody()->getContents();
        $campaigns = json_decode($body);

        if (!is_array($campaigns)) {
            throw new SwiftException('Unexpected response from server: '. $body);
        }

        $data = [];

        foreach ($campaigns as $campaign) {
            $data[] = Campaign::createFromJson($campaign);
        }

        return $data;
    }
}
