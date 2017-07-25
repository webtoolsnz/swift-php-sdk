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
class RecipientLookup extends RecipientView
{

    /**
     * @var integer
     */
    private $account_id;

    /**
     * @var integer
     */
    private $campaign_id;

    /**
     * RecipientView constructor.
     * @param string $account_id
     * @param integer $campaign_id
     */
    public function __construct($account_id, $campaign_id)
    {
        $this->account_id = $account_id;
        $this->campaign_id = $campaign_id;
    }

    /**
     * @return string
     */
    public function getRequestPath()
    {
        return 'recipient/lookup';
    }

    /**
     * @return array
     */
    public function getRequestOptions()
    {
        return ['query' => ['account_id' => $this->account_id, 'campaign_id' => $this->campaign_id]];
    }
}
