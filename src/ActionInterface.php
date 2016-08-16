<?php
/**
 * This file is part of the webtoolsnz\Swift library
 *
 * @license http://opensource.org/licenses/MIT
 * @link https://github.com/webtoolsnz/swift-php-sdk
 * @package webtoolsnz/swift-sdk
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace webtoolsnz\Swift;

use GuzzleHttp\Message\ResponseInterface;

/**
 * Interface ActionInterface
 * @package webtoolsnz\Swift
 */
interface ActionInterface
{
    /**
     * @return string
     */
    public function getRequestMethod();

    /**
     * @return mixed
     */
    public function getRequestPath();

    /**
     * @return array
     */
    public function getRequestOptions();

    /**
     * @param \GuzzleHttp\Message\ResponseInterface $response
     * @return mixed
     */
    public function processResponse(ResponseInterface $response);
}
