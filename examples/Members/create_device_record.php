<?php
namespace Route4Me;

$root = realpath(dirname(__FILE__).'/../../');
require $root.'/vendor/autoload.php';

use Route4Me\Route4Me;
use Route4Me\Member;

// Example refers to creating of a mobile device license record.

// Set the API key in the Route4Me class
Route4Me::setApiKey('11111111111111111111111111111111');

$recordParameters = Member::fromArray(array(
    'device_id'   => '546546516',
    'device_type' => 'IPAD',
    'format'      => 'json',
));

$member = new Member();

$response = $member->addDeviceRecord($recordParameters);

var_dump($response); 
