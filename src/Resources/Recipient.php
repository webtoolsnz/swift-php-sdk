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
 * Class Campaign
 * @package webtoolsnz\Swift\Resources
 */
class Recipient extends Resource
{
    /**
     * Unique ID for this recipient
     * @var integer
     */
    public $id;

    /**
     * ID of the campaign the recipient is attached to.
     * @var integer
     */
    public $campaign_id;

    /**
     * @var string
     */
    public $account_id;

    /**
     * @var string
     */
    public $first_name;

    /**
     * @var string
     */
    public $last_name;

    /**
     * @var string
     */
    public $mobile_number;

    /**
     * @var string
     */
    public $status;

    /**
     * @var integer
     */
    public $status_id;

    /**
     * @var
     */
    public $link;

    /**
     * @var Field[]
     */
    public $form = [];

    /**
     * @param array $data
     */
    public function setForm($data)
    {
        if (!is_array($data)) {
            return;
        }

        foreach ($data as $field) {
            $this->form[] = Field::createFromJson($field);
        }
    }
}
