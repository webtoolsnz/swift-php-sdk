<?php

namespace webtoolsnz\Swift\tests;

use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use webtoolsnz\Swift\Swift;

class GetMediaTest extends \PHPUnit_Framework_TestCase
{
    public function testGetRecipientWithForm()
    {
        $client = new Client();
        $json = file_get_contents(__DIR__ . '/data/get-media.json');
        $content = Stream::factory($json);
        $mock = new Mock([new Response(200, [], $content)]);
        $client->getEmitter()->attach($mock);

        $swift = new Swift('', '', $client);
        $resource = $swift->getMedia(123);

        self::assertInstanceOf('\webtoolsnz\Swift\Resources\Media', $resource);

        self::assertEquals('image/png', $resource->mime);
        self::assertEquals('02083e9e-fd56-443f-9d6c-9560140e308a.png', $resource->filename);
        self::assertEquals('I cannot abide useless people.', $resource->content);
    }
}
