<?php

namespace webtoolsnz\Swift\tests;

use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use webtoolsnz\Swift\Resources\Recipient;
use webtoolsnz\Swift\Swift;

class CreateRecipientTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateRecipient()
    {
        $client = new Client();
        $json = file_get_contents(__DIR__ . '/data/create-recipient.json');
        $content = Stream::factory($json);
        $mock = new Mock([
            //new Response(201, ['Location' => 'http://foo.com/recipient/view?id=123'], Stream::factory('{}')),
            new Response(200, [], $content),
        ]);

        $client->getEmitter()->attach($mock);

        $swift = new Swift('', '', $client);

        $recipient = new Recipient();
        $recipient->campaign_id = 1;
        $recipient->first_name = 'Philip';
        $recipient->last_name = 'Fry';
        $recipient->account_id = 'ABCDEFG';
        $recipient->mobile_number = '+6421234567';

        $resource = $swift->createRecipient($recipient);

        self::assertInstanceOf('\webtoolsnz\Swift\Resources\Recipient', $resource);

        self::assertEquals('Philip', $resource->first_name);
        self::assertEquals('+6421234567', $resource->mobile_number);
    }
}
