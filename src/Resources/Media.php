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

namespace webtoolsnz\Swift\Resources;

use webtoolsnz\Swift\Resource;

/**
 * Class Media
 * @package webtoolsnz\Swift\Resources
 */
class Media extends Resource
{
    /**
     * @var string
     */
    public $filename;

    /**
     * @var string
     */
    public $mime;

    /**
     * file contents
     *
     * @var string
     */
    public $content;

    /**
     * Convert base64 encoded data
     *
     * @param $value
     */
    public function setContent($value)
    {
        $this->content = base64_decode($value);
    }
}
