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

/**
 * Class Resource
 * @package webtoolsnz\Swift
 */
abstract class Resource implements \JsonSerializable
{
    /**
     * @param \stdClass $json
     * @return static
     */
    public static function createFromJson(\stdClass $json)
    {
        $resource = new static;
        $class = new \ReflectionClass($resource);

        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $name = $property->getName();
            if (property_exists($json, $name)) {
                $resource->setProperty($name, $json->$name);
            }
        }

        return $resource;
    }

    /**
     * Serialize this resource into an array for json
     *
     * @return array
     */
    public function jsonSerialize()
    {
        $class = new \ReflectionClass($this);
        $json = [];

        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if (null !== ($value = $property->getValue($this))) {
                $json[$property->getName()] = $value;
            }
        }

        return $json;
    }

    /**
     * @param $name
     * @param $value
     */
    public function setProperty($name, $value)
    {
        $setter = 'set'.$name;

        if (method_exists($this, $setter) && $value !== null) {
            call_user_func([$this, $setter], $value);
            return;
        }

        $this->$name = $value;
    }
}
