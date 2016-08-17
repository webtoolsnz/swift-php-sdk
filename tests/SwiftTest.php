<?php

namespace webtoolsnz\Swift\tests;

use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use webtoolsnz\Swift\Resources\Recipient;
use webtoolsnz\Swift\Swift;

class SwiftTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $swift = new Swift('http://test.swift-app.com.au', '123');
        $reflection = new \ReflectionClass($swift);

        // test http client
        $client = $reflection->getProperty('http');
        $client->setAccessible(true);
        self::assertNotNull($client->getValue($swift));
        self::assertInstanceOf('\GuzzleHttp\Client', $client->getValue($swift));

        // test endPoint
        $endPoint = $reflection->getProperty('endPoint');
        $endPoint->setAccessible(true);
        self::assertEquals('http://test.swift-app.com.au', $endPoint->getValue($swift));

        // test apiKey
        $key = $reflection->getProperty('key');
        $key->setAccessible(true);
        self::assertEquals('123', $key->getValue($swift));
    }

    public function testUnknownException()
    {
        $this->setExpectedException('\webtoolsnz\Swift\Exceptions\SwiftException', 'Some Unexpected Response!');

        $client = new Client();
        $content = Stream::factory('Some Unexpected Response!');

        $mock = new Mock([new Response(500, [], $content)]);
        $client->getEmitter()->attach($mock);
        (new Swift('', '', $client))->getCampaigns();
    }

    public function testInvalidKey()
    {
        $this->setExpectedException('\webtoolsnz\Swift\Exceptions\AuthenticationException', 'You are requesting with an invalid credential.');

        $client = new Client();
        $content = Stream::factory(json_encode([
            'name' => 'Unauthorized',
            'message' => 'You are requesting with an invalid credential.',
        ]));

        $mock = new Mock([new Response(401, [], $content)]);
        $client->getEmitter()->attach($mock);

        (new Swift('', '', $client))->getCampaigns();
    }

    public function testValidationError()
    {
        $this->setExpectedException('\webtoolsnz\Swift\Exceptions\DataValidationException');

        $client = new Client();
        $content = Stream::factory(json_encode([
            ['field' => 'first_name', 'message' => 'That names no good'],
        ]));

        $mock = new Mock([new Response(422, [], $content)]);
        $client->getEmitter()->attach($mock);

        (new Swift('', '', $client))->createRecipient(new Recipient());
    }
}
