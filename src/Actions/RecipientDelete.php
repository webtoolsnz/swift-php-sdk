<?php

namespace webtoolsnz\Swift\Actions;

use GuzzleHttp\Message\ResponseInterface;
use webtoolsnz\Swift\ActionInterface;
use webtoolsnz\Swift\Exceptions\SwiftException;

/**
 * Class RecipientDelete
 * @package webtoolsnz\Swift\Actions
 */
class RecipientDelete implements ActionInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * RecipientDelete constructor.
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
        return 'POST';
    }

    /**
     * @return string
     */
    public function getRequestPath()
    {
        return 'recipient/delete';
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
     */
    public function processResponse(ResponseInterface $response)
    {
        if ($response->getStatusCode() !== 204) {
            throw new SwiftException('Failed to delete recipient');
        }
    }
}
