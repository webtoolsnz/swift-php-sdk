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
 * Class Country
 * @package webtoolsnz\Swift\Resources
 */
class Country extends Resource
{
    /**
     * ISO 3166-1 alpha-2 code for country
     * @var string
     */
    public $code;

    /**
     * Country name
     * @var String
     */
    public $description;
}
