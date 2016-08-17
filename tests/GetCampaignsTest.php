<?php

namespace webtoolsnz\Swift\tests;

use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use webtoolsnz\Swift\Swift;

class GetCampaignsTest extends \PHPUnit_Framework_TestCase
{
    public function testGetCampaigns()
    {
        $client = new Client();
        $json = file_get_contents(__DIR__ . '/data/campaign-list.json');
        $content = Stream::factory($json);
        $mock = new Mock([new Response(200, [], $content)]);
        $client->getEmitter()->attach($mock);

        $swift = new Swift('', '', $client);
        $resources = $swift->getCampaigns();

        self::assertTrue(is_array($resources));
        self::assertEquals(3, count($resources));
        self::assertInstanceOf('\webtoolsnz\Swift\Resources\Campaign', $resources[0]);
        self::assertEquals('Test Campaign 1', $resources[0]->description);
        self::assertInstanceOf('\webtoolsnz\Swift\Resources\Country', $resources[0]->country);
        self::assertEquals('New Zealand', $resources[0]->country->description);
        self::assertInstanceOf('\webtoolsnz\Swift\Resources\Form', $resources[0]->form);

        self::assertInstanceOf('\webtoolsnz\Swift\Resources\Campaign', $resources[1]);
        self::assertEquals('Test Campaign 2', $resources[1]->description);
    }

    public function testUnexpectedResult()
    {
        $client = new Client();
        $content = Stream::factory('ABC');
        $mock = new Mock([new Response(200, [], $content)]);
        $client->getEmitter()->attach($mock);

        $this->setExpectedException('\webtoolsnz\Swift\Exceptions\SwiftException', 'Unexpected response from server: ABC');
        
        $swift = new Swift('', '', $client);
        $swift->getCampaigns();
    }
}
