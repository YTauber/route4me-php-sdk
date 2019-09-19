<?php

namespace Route4Me;

use Route4Me\Enum\DeviceType;
use Route4Me\Enum\Format;

class TrackTest extends \PHPUnit_Framework_TestCase
{
    protected $test_route_id = '196cf29ed924523e198009cd96deada3';

    public function testSetPosition()
    {
        $params = TrackSetParams::fromArray([
            'format' => Format::CSV,
            'route_id' => $this->test_route_id,
            'member_id' => 1,
            'course' => 1,
            'speed' => 120,
            'lat' => 41.8927521,
            'lng' => -109.0803888,
            'device_type' => DeviceType::IPHONE,
            'device_guid' => 'qweqweqwe',
            'device_timestamp' => date('Y-m-d H:i:s'),
        ]);

        $status = Track::set($params);
        $this->assertTrue($status);
    }
}
