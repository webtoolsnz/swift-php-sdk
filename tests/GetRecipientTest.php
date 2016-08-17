<?php

namespace webtoolsnz\Swift\tests;

use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use webtoolsnz\Swift\Swift;

class GetRecipientTest extends \PHPUnit_Framework_TestCase
{
    public function testGetCampaigns()
    {
        $client = new Client();
        $json = file_get_contents(__DIR__ . '/data/get-recipient-with-form.json');
        $content = Stream::factory($json);
        $mock = new Mock([new Response(200, [], $content)]);
        $client->getEmitter()->attach($mock);

        $swift = new Swift('', '', $client);
        $resource = $swift->getRecipient(123);

        self::assertInstanceOf('\webtoolsnz\Swift\Resources\Recipient', $resource);

        self::assertEquals('Philip', $resource->first_name);
        self::assertEquals('+6421234567', $resource->mobile_number);

        self::assertTrue(is_array($resource->form));
        self::assertEquals(2, count($resource->form));
        self::assertInstanceOf('\webtoolsnz\Swift\Resources\Field', $resource->form[0]);
    }
}
