<?php

namespace webtoolsnz\Swift\Actions;

use GuzzleHttp\Message\ResponseInterface;
use webtoolsnz\Swift\ActionInterface;
use webtoolsnz\Swift\Resources\Media as MediaResource;

/**
 * Class Media
 * @package webtoolsnz\Swift\Actions
 */
class Media implements ActionInterface
{
    /**
     * @var string
     */
    private $filename;

    /**
     * Media constructor.
     * @param $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
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
        return 'media';
    }

    /**
     * @return array
     */
    public function getRequestOptions()
    {
        return ['query' => ['file' => $this->filename]];
    }

    /**
     * @param ResponseInterface $response
     * @return  MediaResource
     */
    public function processResponse(ResponseInterface $response)
    {
        $obj = json_decode($response->getBody()->getContents());
        return MediaResource::createFromJson($obj);
    }
}
