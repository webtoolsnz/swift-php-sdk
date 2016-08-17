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
class Campaign extends Resource
{
    /**
     * Unique ID for this campaign
     * @var integer
     */
    public $id;

    /**
     * Short description of the campaign
     *
     * @var string
     */
    public $description;

    /**
     * Campaign Notes
     *
     * @var string
     */
    public $note;

    /**
     * When the campaign was created
     * @var \DateTime
     */
    public $created_at;

    /**
     * When the campaign was last updated.
     * @var \DateTime
     */
    public $updated_at;

    /**
     * @var Country
     */
    public $country;

    /**
     * @var Form
     */
    public $form;

    /**
     * @param \stdClass $data
     */
    public function setCountry($data)
    {
        $this->country = Country::createFromJson($data);
    }

    /**
     * @param \stdClass $data
     */
    public function setForm($data)
    {
        $this->form = Form::createFromJson($data);
    }
}
