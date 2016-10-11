<?php

namespace webtoolsnz\Swift\tests;

use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use webtoolsnz\Swift\Swift;

class DeleteRecipientTest extends \PHPUnit_Framework_TestCase
{
    public function testDeleteRecipientWithForm()
    {
        $client = new Client();
        $mock = new Mock([new Response(204, [], null)]);
        $client->getEmitter()->attach($mock);

        $swift = new Swift('', '', $client);
        $result = $swift->deleteRecipient(123);

        self::assertEquals(null, $result);
    }

    public function testUnexpectedResponse()
    {
        $this->setExpectedException('webtoolsnz\Swift\Exceptions\SwiftException', 'Failed to delete recipient');

        $client = new Client();
        $mock = new Mock([new Response(200, [], null)]);
        $client->getEmitter()->attach($mock);

        $swift = new Swift('', '', $client);
        $result = $swift->deleteRecipient(123);

        self::assertEquals(null, $result);
    }
}
